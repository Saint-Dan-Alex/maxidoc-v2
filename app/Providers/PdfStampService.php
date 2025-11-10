<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Log;

class PdfStampService
{
    public function addFooterDates(string $sourcePath, string $destinationPath, string $archivedAt, string $desarchivedAt): void
    {
        // Normaliser le PDF en PDF 1.4 pour compatibilité avec le parser FPDI gratuit
        $normalizedPath = $this->normalizePdf($sourcePath);

        // Logging de secours (hors Laravel): écrire dans storage/logs/custom-pdf.log
        try {
            $lf = function(string $msg) {
                $file = storage_path('logs/custom-pdf.log');
                @file_put_contents($file, '['.date('Y-m-d H:i:s')."] addFooterDates: $msg\n", FILE_APPEND);
            };
            $lf('start source='.$sourcePath.' normalized='.$normalizedPath.' dest='.$destinationPath);
        } catch (\Throwable $__) {}

        // Log de diagnostic: FPDI présent ?
        Log::info('[PDF] FPDI presence check', [
            'class_exists' => class_exists(\setasign\Fpdi\Fpdi::class),
            'source' => $sourcePath,
            'normalized' => $normalizedPath,
            'destination' => $destinationPath,
        ]);

        $pdf = new Fpdi();
        try {
            $pageCount = $pdf->setSourceFile($normalizedPath);
        } catch (\Throwable $e) {
            try { $lf('FPDI setSourceFile FAILED: '.$e->getMessage()); } catch (\Throwable $__) {}
            // Sur hébergement mutualisé (ex: Hostinger), FPDI peut échouer sur les PDF 1.5+
            Log::warning('[PDF] FPDI setSourceFile failed, fallback to copy', [
                'error' => $e->getMessage(),
                'source' => $sourcePath,
                'normalized' => $normalizedPath,
                'destination' => $destinationPath,
            ]);
            // Filet de sécurité: on copie simplement le PDF pour ne pas bloquer le désarchivage
            if (@copy($normalizedPath, $destinationPath) || @copy($sourcePath, $destinationPath)) {
                try { $lf('fallback COPY success to '.$destinationPath); } catch (\Throwable $__) {}
                return; // on sort sans stamper
            }
            try { $lf('fallback COPY failed'); } catch (\Throwable $__) {}
            throw $e; // si la copie échoue, relancer l'erreur initiale
        }

        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Pied de page
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(100, 100, 100);
            $pdf->SetXY(10, $size['height'] - 15);

            $text = "Document archivé le : $archivedAt | Désarchivé le : $desarchivedAt";
            $pdf->Cell(0, 10, $text, 0, 0, 'C');
        }

        $pdf->Output($destinationPath, 'F');
        try { $lf('stamp success to '.$destinationPath); } catch (\Throwable $__) {}
    }

    /**
     * Convertit un PDF en PDF 1.4 si possible (Ghostscript requis)
     * Retourne le chemin du fichier normalisé, sinon le chemin source si conversion impossible.
     */
    private function normalizePdf(string $sourcePath): string
    {
        try {
            if (!is_file($sourcePath)) {
                try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: source not file: $sourcePath\n", FILE_APPEND); } catch (\Throwable $__) {}
                Log::warning('[PDF] normalizePdf: source not a file', ['source' => $sourcePath]);
                return $sourcePath;
            }

            // Déterminer la commande Ghostscript selon l'OS
            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            $whichBins = $isWindows ? ['gswin64c', 'gswin32c'] : ['gs'];

            $gsBin = null;
            // 1) via which/where
            foreach ($whichBins as $bin) {
                $which = $isWindows ? "where $bin" : "which $bin";
                $resolved = @shell_exec($which);
                if ($resolved) {
                    $candidate = trim(explode(PHP_EOL, $resolved)[0]);
                    if ($candidate && file_exists($candidate)) { $gsBin = $candidate; break; }
                }
            }
            // 2) chemins connus Unix
            if (!$gsBin && !$isWindows) {
                foreach (['/usr/bin/gs','/usr/local/bin/gs','/bin/gs'] as $p) {
                    if (file_exists($p) && is_executable($p)) { $gsBin = $p; break; }
                }
            }

            if (!$gsBin) {
                try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: gs not found\n", FILE_APPEND); } catch (\Throwable $__) {}
                // Ghostscript indisponible, on retourne le fichier original
                Log::warning('[PDF] normalizePdf: Ghostscript not found, skipping normalization');
                return $sourcePath;
            }

            $tmpDir = sys_get_temp_dir();
            $outPath = rtrim($tmpDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'normalized_' . uniqid() . '.pdf';

            $cmd = sprintf(
                '"%s" -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/prepress -dNOPAUSE -dBATCH -sOutputFile=%s %s 2>&1',
                $gsBin,
                escapeshellarg($outPath),
                escapeshellarg($sourcePath)
            );

            Log::info('[PDF] normalizePdf: running Ghostscript', ['bin' => $gsBin, 'cmd' => $cmd, 'out' => $outPath]);
            try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: run $cmd\n", FILE_APPEND); } catch (\Throwable $__) {}

            $output = @shell_exec($cmd);
            try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: gs output: $output\n", FILE_APPEND); } catch (\Throwable $__) {}
            Log::info('[PDF] normalizePdf: gs output', ['output' => $output]);

            if (is_file($outPath) && filesize($outPath) > 0) {
                Log::info('[PDF] normalizePdf: success', ['out' => $outPath, 'size' => filesize($outPath)]);
                try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: success $outPath\n", FILE_APPEND); } catch (\Throwable $__) {}
                return $outPath;
            }

            // Si la conversion a échoué, on utilise le fichier d'origine
            Log::warning('[PDF] normalizePdf: conversion failed, using source', ['out' => $outPath]);
            try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: conversion failed\n", FILE_APPEND); } catch (\Throwable $__) {}
            return $sourcePath;
        } catch (\Throwable $e) {
            // En cas d'erreur quelconque, on retombe sur le fichier d'origine
            Log::error('[PDF] normalizePdf: error', ['message' => $e->getMessage()]);
            try { @file_put_contents(storage_path('logs/custom-pdf.log'), '['.date('Y-m-d H:i:s')."] normalizePdf: error: {$e->getMessage()}\n", FILE_APPEND); } catch (\Throwable $__) {}
            return $sourcePath;
        }
    }
}
