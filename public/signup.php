<?php require '../backend/Register.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Formulaire d'inscription</h1>

    <?php if (isset($msgError)) { ?>
    <p style="color: red;"><?= htmlspecialchars($msgError) ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="fname" placeholder="Nom et prénom" required>
        <br>
        <input type="email" name="email" placeholder="Adresse e-mail" required>
        <br>
        <input type="password" name="mdp1" placeholder="Mot de passe" required>
        <br>
        <input type="password" name="mdp2" placeholder="Confirmer le mot de passe" required>
        <br>
        <button type="submit" name="register">S'inscrire</button>
    </form>
</body>

</html>