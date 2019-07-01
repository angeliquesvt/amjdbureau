<?php
require_once 'inc/bootstrap.php';
App::getAuth()->restrict();
$db = App::getDatabase();
$image = new Image();


$user = $db->query("SELECT * FROM amjd2018 WHERE id= ?", [$_GET['id']])->fetch();
if (!$user) {
  header("Location: main.php");
}

$id_user = $user->id;

if (isset($_POST) && !empty($_POST)) {
  if ($_FILES['avatarToUpload']["error"] == 0) {
    $image = new Image();
    $image = $image->uploadimg($_FILES['avatarToUpload'], "avatar");
    if ($image) {
      $db->query("UPDATE amjd2018 SET picture = ? WHERE id= ?", [$image, $id_user]);
    }
  }
  if (isset($_POST['group'])) {
    $db->query('UPDATE amjd2018 SET groupe = ? WHERE id= ?', [$_POST['group'], $id_user]);
  }
  if (isset($_POST['lastname'])) {
    $db->query('UPDATE amjd2018 SET nom = ? WHERE id= ?', [$_POST['lastname'], $id_user]);
  }
  if (isset($_POST['lastname2'])) {
    $db->query('UPDATE amjd2018 SET nom2 = ? WHERE id= ?', [$_POST['lastname2'], $id_user]);
  }
  if (isset($_POST['firstname'])) {
    $db->query('UPDATE amjd2018 SET prenom = ? WHERE id= ?', [$_POST['firstname'], $id_user]);
  }
  if (isset($_POST['birthdate'])) {
    $db->query('UPDATE amjd2018 SET datenaiss = ? WHERE id= ?', [$_POST['birthdate'], $id_user]);
  }
  if (isset($_POST['adress'])) {
    $db->query('UPDATE amjd2018 SET adresse1 = ? WHERE id= ?', [$_POST['adress'], $id_user]);
  }
  if (isset($_POST['cp'])) {
    $db->query('UPDATE amjd2018 SET cp = ? WHERE id= ?', [$_POST['cp'], $id_user]);
  }
  if (isset($_POST['city'])) {
    $db->query('UPDATE amjd2018 SET ville = ? WHERE id= ?', [$_POST['city'], $id_user]);
  }
  if (isset($_POST['adress2'])) {
    $db->query('UPDATE amjd2018 SET adresse2 = ? WHERE id= ?', [$_POST['adress2'], $id_user]);
  }
  if (isset($_POST['email'])) {
    $db->query('UPDATE amjd2018 SET email1 = ? WHERE id= ?', [$_POST['email'], $id_user]);
  }
  if (isset($_POST['email2'])) {
    $db->query('UPDATE amjd2018 SET email2 = ? WHERE id= ?', [$_POST['email2'], $id_user]);
  }
  if (isset($_POST['tel1'])) {
    $db->query('UPDATE amjd2018 SET tel1 = ? WHERE id= ?', [$_POST['tel1'], $id_user]);
  }
  if (isset($_POST['tel2'])) {
    $db->query('UPDATE amjd2018 SET tel2 = ? WHERE id= ?', [$_POST['tel2'], $id_user]);
  }
  if (isset($_POST['port1'])) {
    $db->query('UPDATE amjd2018 SET port1 = ? WHERE id= ?', [$_POST['port1'], $id_user]);
  }
  if (isset($_POST['port2'])) {
    $db->query('UPDATE amjd2018 SET port2 = ? WHERE id= ?', [$_POST['port2'], $id_user]);
  }
  if (isset($_POST['remarques'])) {
    $db->query('UPDATE amjd2018 SET remarques = ? WHERE id= ?', [$_POST['remarques'], $id_user]);
  }
  if (isset($_POST['cotis'])) {
    $db->query('UPDATE amjd2018 SET cotis = ? WHERE id= ?', [$_POST['cotis'], $id_user]);
  }
  if (isset($_POST['droit']) && $_POST['droit'] != $user->droitimage) {
    $db->query('UPDATE amjd2018 SET droitimage = ? WHERE id= ?', [$_POST['droit'], $id_user]);
  }
  if (isset($_POST['certif']) && $_POST['certif'] != $user->certificat ) {
    $db->query('UPDATE amjd2018 SET certificat = ? WHERE id= ?', [$_POST['certif'], $id_user]);
  }
  if (isset($_POST['paye']) && $_POST['paye'] != $user->paye ) {
    $db->query('UPDATE amjd2018 SET paye = ? WHERE id= ?', [$_POST['paye'], $id_user]);
    var_dump("sdsqdsqdqsd");

  }
  if (isset($_POST['montant'])) {
    $db->query('UPDATE amjd2018 SET montant = ? WHERE id= ?', [$_POST['montant'], $id_user]);

  }
  header("Refresh:0");
}
if (isset($_POST['delete'])) {
  $db->query('DELETE FROM amjd2018 WHERE id= ?', [$id_user]);
  header("Location:main.php");
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
      <div class="Navbar_item"><a href="logout.php">Déconnexion</a></div>
    </div>
  <?php endif; ?>

  <div class="Wrapper">
    <div class="Edit_back"><a class="Edit_back" href="main.php">Retour</a></div>

    <div class="Form">
      <div class="Edit_avatar">
        <img class="User_picture" src='<?= $image->getImage($user->picture, "avatar"); ?>' alt="">
      </div>
      <div class="Form_title">
        <?= $user->prenom ?> <?= $user->nom ?>
        <hr/>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="Form_inputs">
          <div class="Form_inscription">
            <div class="Form_picture">
              <input class="inputfile" type="file" name="avatarToUpload" id="avatar" />
              <label class="Form_label" for="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg><span>Selectionner une photo</span></label>
            </div>
            <div class="Form_row">
              <div>
                <label class="Form_label">Nom</label>
                <input type="text" value="<?= $user->nom ?>" name="lastname">
              </div>
              <div>
                <label class="Form_label">Nom 2</label>
                <input type="text" value="<?= $field = ($user->nom2 != 'NULL') ? $user->nom2 : "" ?>" name="lastname2">
              </div>
            </div>
            <div class="Form_row">
              <div>
                <label class="Form_label">Prénom</label>
                <input type="text" value="<?= $user->prenom ?>" name="firstname">
              </div>
            </div>
            <div class="Form_row">
              <div class="">
                <label class="Form_label">Groupe</label>
                <input type="text" value="<?= $user->groupe ?>" name="group">
              </div>
              <div class="">
                <label class="Form_label">Date de naissance</label>
                <input type="date" value="<?= $user->datenaiss ?>" name="birthdate">
              </div>
            </div>
            <div class="Form_row">
              <div class="Form_adress">
                <label class="Form_label">Adresse</label>
                <input class="Form_adress" type="text" value="<?= $user->adresse1 ?>" name="adress">
              </div>
            </div>
            <div class="Form_row">
              <div class="Form_adress">
                <label class="Form_label">Adresse 2</label>
                <input class="Form_adress" type="text" value="<?= $field = ($user->adresse2 != 'NULL') ? $user->adresse2 : "" ?>" name="adress2">
              </div>
            </div>
            <div class="Form_row">
              <div class="">
                <label class="Form_label">Code Postal</label>
                <input type="text" value="<?= $field = ($user->cp != 'NULL') ? $user->cp : "" ?>" name="cp">
              </div>
              <div class="">
                <label class="Form_label">Ville</label>
                <input type="text" value="<?= $field = ($user->ville != 'NULL') ? $user->ville : "" ?>" name="city">
              </div>
            </div>
            <div class="Form_row">
              <div class="">
                <label class="Form_label">Email 1</label>
                <input type="email" value="<?= $user->email1 ?>" name="email">
              </div>
              <div class="">
                <label class="Form_label">Email 2</label>
                <input type="email" value="<?= $field = ($user->email2 != 'NULL') ? $user->email2 : "" ?>" name="email2">
              </div>
            </div>
            <div class="Form_row">
              <div class="">
                <label class="Form_label">Tel1</label>
                <input type="text" value="<?= $field = ($user->tel1 != 'NULL') ? $user->tel1 : "" ?>" name="tel1">
              </div>
              <div class="">
                <label class="Form_label">Port1</label>
                <input type="text" value="<?= $field = ($user->port1 != 'NULL') ? $user->port1 : "" ?>" name="port1">
              </div>
            </div>
            <div class="Form_row">
              <div class="">
                <label class="Form_label">Tel2</label>
                <input type="text" value="<?= $field = ($user->tel2 != 'NULL') ? $user->tel2 : "" ?>" name="tel2">
              </div>
              <div class="">
                <label class="Form_label">Port2</label>
                <input type="text" value="<?= $field = ($user->port2 != 'NULL') ? $user->port2 : "" ?>" name="port2">
              </div>
            </div>
            <div class="Form_margin">
              <div class="Form_row">
                <div class="Form_inputRadio">
                  <div class="Form_row">
                    <label class="Form_label"> Droit à l'image * </label>
                  </div>
                  <div class="Form_row">
                    <div class="Form_inputRadio">
                      <input class="Form_radio" type="radio" id="droit1" name="droit" value="oui" <?php if($user->droitimage == "oui") { echo 'checked'; } ?>>
                      <label for="droit1"> Oui </label>
                      <input class="Form_radio" type="radio" id="droit2" name="droit" value="non" <?php if($user->droitimage == "non") { echo 'checked'; } ?>>
                      <label for="droit2"> Non </label>
                    </div>
                  </div>
                </div>
                <div class="Form_inputRadio">
                  <div class="Form_row">
                    <label class="Form_label"> Certificat médical * </label>
                  </div>
                  <div class="Form_row">
                    <div class="Form_inputRadio">
                      <input class="Form_radio" type="radio" id="certif1" name="certif" value="oui" <?php if($user->certificat == "oui") { echo 'checked'; } ?>>
                      <label for="certif1"> Oui </label>
                      <input class="Form_radio" type="radio" id="certif2" name="certif" value="non" <?php if($user->certificat == "non") { echo 'checked'; } ?>>
                      <label for="certif2"> Non </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="Form_row">
                <label class="Form_label"> Payé * </label>
              </div>
              <div class="Form_row">
                <div class="Form_inputRadio">
                  <input class="Form_radio" type="radio" id="paye1" name="paye" value="oui" <?php if($user->paye == "oui") { echo 'checked'; } ?>>
                  <label for="paye1"> Oui </label>
                  <input class="Form_radio" type="radio" id="paye2" name="paye" value="non" <?php if($user->paye == "non") { echo 'checked'; } ?>>
                  <label for="paye2"> Non </label>
                </div>
              </div>
              <div class="Form_row">
                <div class="">
                  <label class="Form_label">Montant</label>
                  <input class="Form_montant" type="text" name="montant" value="<?= $user->montant ?>">
                </div>

              </div>
            </div>
            <div class="Form_row">
              <div class="Form_adress">
                <label class="Form_label">Remarques</label>
                <textarea class="Form_adress" rows="5" type="text" name="remarques"> <?= $field = ($user->remarques != 'NULL') ? $user->remarques : "" ?> </textarea>
              </div>
            </div>
            <div class="Form_row">
              <div class="Form_adress">
                <label class="Form_label">Cotisations</label>
                <textarea class="Form_adress" rows="5" type="text" name="cotis"> <?= $field = ($user->cotis != 'NULL') ? $user->cotis : "" ?> </textarea>
              </div>
            </div>
            <div class="Form_footer">
              <button class="Form_validate" type="submit">Valider</button>
            </div>
          </div>

        </div>
      </form>
    </div>
    <div class="Form_delete">
      <form action="" method="post">
        <input type="hidden" name="delete">
        <input class="Form_delete--input" type="submit" value="Supprimer cet adhérent">
      </form>
    </div>
  </div>
</body>
</html>
