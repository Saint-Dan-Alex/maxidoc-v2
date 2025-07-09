<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création du document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0
        }
        /* .preview-doc {
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            font-size: 14px;
            width: 795px;
            line-height: 1.6;
            font-family: 'Times New Roman', Times, serif;
            min-height: 1122px;
            padding: 37px;
        } */
        .header, .footer {
            text-align: right;
        }
        .destinataire {
            margin-top: 2cm;
        }
        .objet {
            margin-top: 1cm;
            font-weight: bold;
            text-decoration: underline;
        }
        .content {
            margin-top: 1cm;
            text-align: justify;
        }
        .signature {
            margin-top: 2cm;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="preview-doc">
        <div class="header">
            <p id="preview-lieu_date">{{ $lieu_date }}</p>
        </div>
        <div class="destinataire">
            <p id="preview-dest">{{ $dest }}</p>
            <p id="preview-ville">{{ $ville }}</p>
        </div>
        <div class="objet">
            <p>Objet: <span id="preview-objet">{{ $objet }}</span></p>
        </div>
        <div class="content">
            <p id="preview-content">{!! nl2br($content) !!}</p>
        </div>
        <div class="signature">
            <p id="preview-exp_fonction">{{ $exp_fonction }}</p>
            <p id="preview-exp_name">{{ $exp_name }}</p>
        </div>
    </div>
    
</body>
</html>
