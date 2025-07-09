<x-mail::message>

    # Bienvenue sur MaxiDoc !
    Vous êtes sur le point de signer un document depuis votre profil utilisateur MaxiDoc eSignature.

    Voici votre code de confirmation à 6 chiffres
    # {{ $password }}

    Si ce n’était pas vous, veuillez changer votre mot de passe immédiatement pour sécuriser votre compte.
    Pour plus de sécurité, nous vous recommandons de contacter l’administrateur de votre compte.
    Bien à vous,

    L'équipe {{ config('app.name') }}

</x-mail::message>
