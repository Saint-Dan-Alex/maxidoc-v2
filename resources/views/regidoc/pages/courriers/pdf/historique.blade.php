<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Historique du courrier #{{ $courrier->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section h2 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-size: 18px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #7f8c8d;
            margin-bottom: 3px;
        }
        .info-value {
            color: #2c3e50;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .history-table th, .history-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .history-table th {
            background-color: #f2f2f2;
            color: #2c3e50;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HISTORIQUE DU COURRIER #{{ $courrier->id }}</h1>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="info-section">
        <h2>Détails du courrier</h2>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Référence</div>
                <div class="info-value">{{ $courrier->reference_interne ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date de création</div>
                <div class="info-value">{{ $courrier->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Type</div>
                <div class="info-value">{{ $courrier->type->titre ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Objet</div>
                <div class="info-value">{{ $courrier->objet ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Statut</div>
                <div class="info-value">{{ $courrier->document->statut->titre ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Priorité</div>
                <div class="info-value">{{ $courrier->priorite->titre ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h2>Historique des activités</h2>
        @if($courrier->historiques->count() > 0)
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Date/Heure</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courrier->historiques as $historique)
                        <tr>
                            <td>{{ $historique->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $historique->user->name ?? 'Système' }}</td>
                            <td>{{ $historique->key }}</td>
                            <td>{{ $historique->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Aucune activité enregistrée pour ce courrier.</p>
        @endif
    </div>

    <div class="footer">
        Document généré par MaxiDoc - {{ config('app.name') }}
    </div>
</body>
</html>
