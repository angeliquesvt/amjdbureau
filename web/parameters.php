<?php
    require_once 'inc/bootstrap.php';
    App::getAuth()->restrict();
    $db = App::getDatabase();

    if(isset($_POST) && !empty($_POST)){

        $validator = new Validator($_POST);

        $validator->isEmpty('annee', "Année");

        if($validator->isValid()){
            $db->query("INSERT INTO annees SET annee = ?", [
                $_POST['annee']
            ]);
        }
    }
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Adhérents AMJD</title>
        <link rel="stylesheet" href="css/global.css">
    </head>
    <body>
        <?php if (isset($_SESSION['auth'])) : ?>
            <div class="Navbar">
                <div class="Navbar_item"><a href="main.php">Accueil</a></div>
                <div class="Navbar_item"><a href="logout.php">Déconnexion</a></div>
            </div>
        <?php endif; ?>
        <div class="Form_adherent">
            <div class="Form Form_small">
                <form method="post" enctype="multipart/form-data">
                    <div class="Form_title">
                        Ajouter une nouvelle année
                        <hr/>
                    </div>
                    <div class="Form_row">
                        <label class="Form_label"> Année (ex : 2018/2019) </label>
                    </div>
                    <div class="Form_row">
                        <input class="Form_adress" type="text" name="annee" placeholder="">
                    </div>

                    <div class="Form_footer">
                        <button class="Form_validate" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
