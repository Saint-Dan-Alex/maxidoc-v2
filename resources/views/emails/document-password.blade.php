<x-mail::message>
    # Bienvenue cher(e) utilisateur MaxiDoc!

    Un document confidentiel vous a été envoyé depuis votre profil utilisateur
    MaxiDoc.
    <br>
    <br>
    Voici votre code de confirmation à 6 chiffres :
    <br>

    {{ $password }}

    <br>
    Cordialement,<br>

    {{ config('app.name') }}

</x-mail::message>
