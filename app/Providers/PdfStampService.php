<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

class PdfStampService
{
    public function addFooterDates(string $sourcePath, string $destinationPath, string $archivedAt, string $desarchivedAt): void
    {
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourcePath);

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
    }
}
