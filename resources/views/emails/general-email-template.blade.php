<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Email de [Nom de votre site immobilier]')</title>
    <style>
        /* Styles CSS en ligne pour la compatibilité maximale des clients de messagerie */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        p {
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        li strong {
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #777;
            font-size: 0.9em;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
            /* Ajustez la taille du logo */
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('logo.png') }}" alt="Logo de votre agence" class="logo">
        <h1>@yield('title_header')</h1> @yield('content') <div class="footer">
            <p>Cordialement,<br>
                L'équipe de [Nom de votre site immobilier]</p>
        </div>
    </div>
</body>

</html>