<?php require '../backend/Login.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Formulaire de Connexion</h1>

    <?php if (isset($msgError)) { ?>
    <p style="color: red;"><?= htmlspecialchars($msgError) ?></p>
    <?php } ?>
    <form method="post">
        <input type="email" name="email" placeholder="Adresse e-mail" required>
        <br><br>
        <input type="password" name="mdp" placeholder="Entrez le mot de passe" required>
        <br><br>
        <button type="submit" name="login">Connexion</button>
    </form>
</body>

</html>