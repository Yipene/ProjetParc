<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Maintenances</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 10mm;
            box-sizing: border-box;
            font-size: 12px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10mm;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-left {
            text-align: left;
            width: 40%;
        }

        .header-center {
            text-align: center;
            width: 20%;
        }

        .header-center img {
            width: 60px;
            height: auto;
        }

        .header-right {
            text-align: center;
            width: 40%;
        }

        .header-left p,
        .header-right p {
            font-weight: bold;
            margin: 0;
        }

        h1 {
            text-align: center;
            margin: 0;
            padding: 10mm 0;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .signature {
            text-align: right;
            margin-top: 20mm;
        }

        .signature p {
            margin: 0;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="header-left">
                <p>Ministère de la Défense et des Anciens Combattants</p>
                <p>Etat-Major Général des Armées</p>
                <p>Direction Centrale des Systèmes d'Information et de la Cyberdéfense</p>
            </td>
            <td class="header-center">
                <img src="{{ asset('upload/dcsic.png') }}" alt="Logo">
            </td>
            <td class="header-right">
                <p>BURKINA FASO</p>
                <p>Unité-Progrès-Justice</p>
                <p>Ouagadougou le, {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>

    <h1>Liste des Maintenances</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Type Équipement</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de Série</th>
                <th>Panne</th>
                <th>Date de Réparation</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($maintenances as $maintenance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $maintenance->equipement->client->nom }} {{ $maintenance->equipement->client->prenom }}</td>
                    <td>{{ $maintenance->equipement->typeEquipement->nom_type ?? 'N/A' }}</td>
                    <td>{{ $maintenance->equipement->marque ?? 'N/A' }}</td>
                    <td>{{ $maintenance->equipement->modele ?? 'N/A' }}</td>
                    <td>{{ $maintenance->equipement->numero_serie ?? 'N/A' }}</td>
                    <td>{{ $maintenance->panne ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($maintenance->date_reparation)->format('d/m/Y') ?? 'N/A' }}</td>
                    <td>{{ $maintenance->statut }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Signature</p>
        <br>
        <br>
        <p>Le gestionnaire</p>
    </div>

</body>

</html>
