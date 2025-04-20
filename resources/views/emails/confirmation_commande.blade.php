<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <style>
        /* Met ici des styles CSS simples et compatibles email */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        h1 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        li img {
            max-width: 60px;
            margin-right: 10px;
            vertical-align: middle;
            border-radius: 3px;
        }

        .total {
            font-weight: bold;
            color: #333;
            margin-top: 15px;
            font-size: 1.1em;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>

    
    <div class="email-container">
        <h1>Merci pour votre commande, {{ $userName }} !</h1>
        <p>Votre numéro de commande est : <strong>{{ $commandeId }}</strong></p>
        <p>Date : {{ $date }}</p>
        <p>Livraison à : {{ $adresseLivraison }}, {{ $codePostal }} {{ $ville }}</p>

        <h2>Détails de la commande :</h2>
        <ul>


            @foreach($articles as $article)
            <li>

                <!-- <img src="{{ url('img/' . $article['image']) }}" alt="{{ $article['name'] }}">
                {{-- Image via $message->embed() --}} -->
                <img src="{{ $message->embed(public_path('img/' . $article['image'])) }}" alt="{{ $article['name'] }}">

                <span>{{ $article['name'] }} (Taille: {{ $article['taille'] }}) - {{ $article['quantity'] }} x {{ number_format($article['price'], 2, ',', ' ') }} €</span>
            </li>
            @endforeach
        </ul>

        <p class="total">Total de la commande : {{ number_format($totalTTC, 2, ',', ' ') }} €</p>

        <div class="footer">
            <p>Cordialement,</p>
            <p>Votre équipe</p>
        </div>
    </div>
</body>

</html>