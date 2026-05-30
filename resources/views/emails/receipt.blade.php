<x-mail::message>
# Félicitations {{ $user->name }} !

Votre paiement a été traité avec succès et votre inscription à **HOREB ACADEMY** est désormais validée. 

Vous trouverez en pièce jointe le reçu officiel de votre paiement.

## Vos Identifiants de Connexion

Un compte étudiant a été créé pour vous. Vous pourrez y consulter votre emploi du temps, vos notes, et télécharger vos documents scolaires.

- **Email académique (Identifiant)** : {{ $user->email }}
- **Mot de passe temporaire** : `{{ $password }}`

<x-mail::button :url="route('login')">
Accéder à mon Portail Étudiant
</x-mail::button>

> **Important :** Lors de votre première connexion, il vous sera demandé de modifier votre mot de passe pour des raisons de sécurité.

Si vous avez des questions, n'hésitez pas à contacter l'administration.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
