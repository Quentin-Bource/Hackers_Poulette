<?php
function validate_input($data)
{
    // Aseptisation des données
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if (isset($_POST['submit'])) {
    // Validation des entrées
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validation du nom
        if (empty($_POST['name'])) {
            echo "Le nom est requis.";
        } else {
            $name = validate_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                echo "Seuls les caractères alphabetiques et les espaces sont autorisés pour le nom.";
            }
        }

        // Validation du prénom
        if (empty($_POST['first_name'])) {
            echo "Le prénom est requis.";
        } else {
            $first_name = validate_input($_POST['first_name']);
            if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
                echo "Seuls les caractères alphabetiques et les espaces sont autorisés pour le prénom.";
            }
        }

        // Validation de l'adresse e-mail
        if (empty($_POST['email'])) {
            echo "L'adresse e-mail est requise.";
        } else {
            $email = validate_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "L'adresse e-mail n'est pas valide.";
            }
        }

        // Validation du commentaire
        if (empty($_POST['comments'])) {
            echo "Le commentaire est requis.";
        } else {
            $comments = validate_input($_POST['comments']);
        }
    }
    $pdo = new PDO('mysql:host=localhost;dbname=becode', 'root', '');

    $query = $pdo->prepare("INSERT INTO hackerspoulette (name, first_name, email, comments) VALUES (:name, :first_name, :email, :comments)");

    // Liaison des valeurs
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':comments', $comments, PDO::PARAM_STR);

    // Exécution de la requête
    $query->execute();

    // Message de confirmation
    echo "Votre message a bien été envoyé !";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Hackers Poulette</title>

</head>

<body>
    <header>

    </header>

    <body>
        <form id="form" action="" method="post">

            <label for="nom">Nom: </label>
            <input type="text" name="name" id="nom" required>
            <br>

            <label for="prénom">Prénom: </label>
            <input type="text" name="first_name" id="prenom" required>
            <br>
            <label for="email">Adresse e-mail: </label>
            <input type="text" name="email" id="email" required>
            <br>
            <label for="commentaire">Commentaire:</label>
            <textarea type="text" name="comments" id="comments" required></textarea>

            <input type="submit" name="submit" value="Envoyer">
        </form>
    </body>

    <footer>


    </footer>

</body>

</html>