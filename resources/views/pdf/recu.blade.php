<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a56db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1a56db;
        }
        .title {
            font-size: 20px;
            margin-top: 10px;
            text-transform: uppercase;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th, .details-table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .details-table th {
            width: 40%;
            color: #555;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #1a56db;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">HOREB ACADEMY</div>
        <div class="title">Reçu de Paiement</div>
    </div>

    <table class="details-table">
        <tr>
            <th>N° de Transaction :</th>
            <td>{{ $paiement->transaction_id }}</td>
        </tr>
        <tr>
            <th>Date de Paiement :</th>
            <td>{{ $paiement->paye_le->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Étudiant :</th>
            <td>{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</td>
        </tr>
        <tr>
            <th>Matricule :</th>
            <td>{{ $inscription->etudiant->matricule }}</td>
        </tr>
        <tr>
            <th>Filière :</th>
            <td>{{ $inscription->filiere->nom }}</td>
        </tr>
        <tr>
            <th>Niveau d'étude :</th>
            <td>{{ $inscription->niveau }}</td>
        </tr>
        <tr>
            <th>Montant Payé :</th>
            <td class="amount">{{ number_format($paiement->montant, 0, ',', ' ') }} XOF</td>
        </tr>
        <tr>
            <th>Moyen de Paiement :</th>
            <td>{{ ucfirst(str_replace('_', ' ', $paiement->methode)) }}</td>
        </tr>
    </table>

    <p>
        Ce document certifie que l'étudiant susmentionné a réglé ses frais de scolarité pour l'année académique {{ $inscription->annee_academique }}.
    </p>

    <div class="footer">
        HOREB ACADEMY - L'excellence au service de votre avenir.<br>
        Ce reçu est généré électroniquement et ne nécessite pas de signature.
    </div>

</body>
</html>
