

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Paiement</title>
<link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" ">
    
    <style>
        body {
            background-color: AliceBlue;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        label {
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Formulaire de Paiement (<?php echo $_GET['plan']; ?>)</h2>
        <form action="post_payment.php" method="POST">

                <label for="card-number">Numéro de Carte <i class="fas fa-info-circle" title="Entrez un numéro de carte valide"></i></label>
                <input type="text" name="card-number" class="form-control" placeholder="Entrez le numéro de votre carte(12 chiffres)" required>
                
                <label for="expiry-date">Date d'Expiration</label>
                <input type="text" name="expiry-date" class="form-control" placeholder="MM/YY(année après 22)" required>
                
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" class="form-control" placeholder="Entrez le code de sécurité(3chiffres)" required>
                
                <label for="name">Nom sur la Carte</label>
                <input type="text" name="name" class="form-control" placeholder="Entrez le nom tel qu'il apparaît sur la carte(pas de chiffres)" required>
                
                <input type="hidden" name="plan" value="<?php echo $_GET['plan']; ?>">
                
            <button type="submit" class="btn btn-primary btn-block">Payer</button>
        </form>
    </div>
</body>
</html>

