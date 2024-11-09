<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dotations PDF</title>
    <style>
        /* Styles pour le PDF */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Liste des Dotations</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Équipement</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de Série</th>
                <th>Quantité</th>
                <th>Date de Dotation</th>
                <th>Bénéficiaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dotations as $dotation)
                <tr>
                    <td>{{ $dotation->id }}</td>
                    <td>{{ $dotation->equipement->typeEquipement->nom_type }}</td>
                    <td>{{ $dotation->equipement->marque }}</td>
                    <td>{{ $dotation->equipement->modele }}</td>
                    <td>{{ $dotation->equipement->numero_serie }}</td>
                    <td>{{ $dotation->quantite }}</td>
                    <td>{{ \Carbon\Carbon::parse($dotation->date_dotation)->format('d/m/Y') }}</td>
                    <td>{{ $dotation->beneficiare }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
