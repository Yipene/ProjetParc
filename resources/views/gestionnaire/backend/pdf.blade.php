<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Acquisitions</title>
    <style>
        @page {
            size: A4;
            /* Définit la taille de la page comme A4 */
            margin: 0;
            /* Supprime les marges par défaut */
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 10mm;
            /* Marges internes */
            box-sizing: border-box;
            font-size: 12px;
            /* Taille de police réduite */
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
            /* Laisse plus d'espace à gauche */
        }

        .header-center {
            text-align: center;
            width: 20%;
            /* Réduit la largeur de la colonne du logo */
        }

        .header-center img {
            width: 60px;
            /* Largeur fixe pour le logo */
            height: auto;
        }

        .header-right {
            text-align: center;
            /* Centrer le texte */
            width: 40%;
            /* Laisse plus d'espace à droite */
        }

        .header-left p,
        .header-right p {
            font-weight: bold;
            /* Texte en gras */
            margin: 0;
            /* Supprime les marges par défaut */
        }

        h1 {
            text-align: center;
            margin: 0;
            /* Supprime la marge par défaut */
            padding: 10mm 0;
            /* Ajoute un peu d'espace autour du titre */
            font-size: 14px;
            /* Taille du titre */
            font-weight: bold;
            /* Titre en gras */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            /* Réduit le padding pour maximiser l'espace */
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            /* En-tête en gras */
        }

        .signature {
            text-align: right;
            /* Aligner la signature à droite */
            margin-top: 20mm;
            /* Espace au-dessus de la signature */
        }

        .signature p {
            margin: 0;
            /* Supprime les marges */
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="header-left">
                <p>Ministère de la Défense et des Anciens Combattants</p>
                <p>Etat-Major Général des Armées</p>
                <p>Direction Centrale des Système d'Information et de la Cyberdéfense</p>
            </td>
            <td class="header-center">
                <img src="{{ public_path('upload/dcsic.png') }}" alt="Logo">

            </td>
            <td class="header-right">
                <p>BURKINA FASO</p>
                <p>Unité-Progrès-Justice</p>
                <p>Ouagadougou le, {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>

    <h1>Liste des Acquisitions</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type Équipement</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Numéro de Série</th>
                <th>Date d'Acquisition</th>
                <th>Provenance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($acquisitions as $acquisition)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $acquisition->equipement->typeEquipement->nom_type ?? 'N/A' }}</td>
                    <td>{{ $acquisition->equipement->marque ?? 'N/A' }}</td>
                    <td>{{ $acquisition->equipement->modele ?? 'N/A' }}</td>
                    <td>{{ $acquisition->equipement->numero_serie ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($acquisition->date_acquisition)->format('d/m/Y') }}</td>
                    <td>{{ $acquisition->provenance ?? 'N/A' }}</td>
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
