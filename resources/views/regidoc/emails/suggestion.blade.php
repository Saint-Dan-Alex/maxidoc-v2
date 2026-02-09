<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 10px; }
        .header { background: #f4f4f4; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 0.8em; color: #777; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-bottom: 15px; }
        .type-suggestion { color: #20bf6b; }
        .type-bug { color: #eb3b5a; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouveau retour utilisateur - Maxidoc</h2>
        </div>
        <div class="content">
            <p><span class="label">Expéditeur :</span> {{ $suggestion->user->name }} ({{ $suggestion->user->email }})</p>
            <p><span class="label">Type :</span> 
                <span class="type-{{ $suggestion->type }}">
                    {{ ucfirst($suggestion->type) }}
                </span>
            </p>
            <p><span class="label">Objet :</span> {{ $suggestion->objet }}</p>
            <p><span class="label">Message :</span></p>
            <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #ccc;">
                {!! nl2br(e($suggestion->message)) !!}
            </div>
        </div>
        <div class="footer">
            Cet email a été envoyé automatiquement depuis la plateforme Maxidoc.
        </div>
    </div>
</body>
</html>
