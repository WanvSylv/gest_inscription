<x-mail::message>
# Bienvenue à HOREB ACADEMY, {{ $user->name }} !

Votre inscription a été validée avec succès.
Voici vos identifiants pour accéder à votre espace étudiant :

**Email :** {{ $user->email }}
**Mot de passe provisoire :** {{ $plainPassword }}

Il vous sera demandé de modifier ce mot de passe lors de votre première connexion.

<x-mail::button :url="route('login')">
Se connecter à mon espace
</x-mail::button>

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
