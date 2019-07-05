<?php
    require_once 'inc/bootstrap.php';
    App::getAuth()->restrict();
    $db = App::getDatabase();

    require_once 'query.php';

    $users = $db->query("SELECT * FROM adherents")->fetchAll();

    $groups = $db->query("SELECT groupe, annee, COUNT(id) AS number FROM `adherents`GROUP BY groupe, annee ORDER BY groupe ASC")->fetchAll();

    $years = $db->query("SELECT annee FROM annees ORDER BY annee DESC")->fetchAll();

    $image = new Image();

    $i = 0;
    $j = 0;
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
            <div class="Navbar_item"><a href="parameters.php">Paramètres</a></div>
            <div class="Navbar_item"><a href="logout.php">Déconnexion</a></div>
        </div>
    <?php endif; ?>

    <div class="Wrapper">
        <div class="User_list">
            <?php foreach ($years as $year) : ?>
                <div class="List User_list js-tab-group <?= $j == 0 ? 'visible-flex' : '' ?>" data-target="groupe-<?= $year->annee ?>">
                    <?php foreach ($groups as $group) : ?>
                        <?php if($group->annee == $year->annee): ?>
                            <a href="#<?= $group->groupe ?>"><?= $group->groupe ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php $j++; ?>
            <?php endforeach; ?>
        </div>

    <div>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <p>Vous n'avez pas rempli le formulaire correctement</p>
                <p>Champs manquants:</p>
                <?php foreach ($errors as $error) : ?>
                    <?= $error; ?> <br/>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="Form_adherent">
            <div class="Form">
                <form method="post" enctype="multipart/form-data">
                    <div class="Form_title">
                        Enregistrer un adhérent
                        <hr/>
                    </div>
                    <div class="Form_inscription">
                        <div class="Form_row Form_picture">
                            <input class="Form_inputfile" type="file" name="avatarToUpload" id="avatar" /> <br/>
                            <label class="Form_label"  for="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg><span>Selectionner une photo</span></label>
                        </div>
                        <div class="Form_row">
                            <input type="text" placeholder="Nom *" name="lastname" required>
                            <input type="text" placeholder="Prénom *" name="firstname" required>
                        </div>
                        <div class="Form_row">
                            <input type="text" placeholder="Nom 2" name="lastname2">
                        </div>
                        <div class="Form_row">
                            <input type="date" placeholder="Naiss JJ/MM/AAAA *" name="birthdate" required>
                            <input type="text" placeholder="Groupe *" name="group" required>
                        </div>
                        <div class="Form_margin">
                            <div class="Form_row">
                                <input class="Form_adress" type="text" placeholder="Adresse *" name="adress" required>
                            </div>
                            <div class="Form_row">

                                <input class="Form_adress" type="text" placeholder="Adresse 2" name="adress2">
                            </div>
                            <div class="Form_row">

                                <input type="text" placeholder="Code postal" name="cp">
                                <input type="text" placeholder="Ville" name="city">
                            </div>
                        </div>

                        <div class="Form_row">

                            <input type="email" placeholder="Email *" name="email">
                            <input type="email" placeholder="Email 2" name="email2">
                        </div>
                        <div class="Form_row">

                            <input type="text" placeholder="Tel 1" name="tel1">
                            <input type="text" placeholder="Port 1" name="port1">
                        </div>
                        <div class="Form_row">

                            <input type="text" placeholder="Tel 2" name="tel2">
                            <input type="text" placeholder="Port 2" name="port2">
                        </div>
                        <div class="Form_margin">
                            <div class="Form_row">
                                <div class="Form_inputRadio">
                                    <div class="Form_row">
                                        <label class="Form_label"> Droit à l'image * </label>
                                    </div>
                                    <div class="Form_row">
                                        <div class="Form_inputRadio">
                                            <input class="Form_radio" type="radio" id="droit1" name="droit" value="oui" required>
                                            <label for="droit1"> Oui </label>
                                            <input class="Form_radio" type="radio" id="droit2" name="droit" value="non">
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
                                            <input class="Form_radio" type="radio" id="certif1" name="certif" value="oui" required>
                                            <label for="certif1"> Oui </label>
                                            <input class="Form_radio" type="radio" id="certif2" name="certif" value="non">
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
                                    <input class="Form_radio" type="radio" id="paye1" name="paye" value="oui" required>
                                    <label for="paye1"> Oui </label>
                                    <input class="Form_radio" type="radio" id="paye2" name="paye" value="non">
                                    <label for="paye2"> Non </label>
                                </div>
                            </div>
                            <div class="Form_row">
                                <input class="Form_montant" type="text" name="montant" placeholder="Montant">
                            </div>
                        </div>
                        <div class="Form_row">
                            <textarea class="Form_adress" rows="5" type="text" placeholder="Remarques" name="remarques"></textarea>
                        </div>
                        <div class="Form_row">
                            <textarea class="Form_adress" rows="5" type="text" placeholder="Cotisation" name="cotis"></textarea>
                        </div>
                        <div class="Form_row">
                            <select class="" name="annee">
                                <?php foreach ($years as $year): ?>
                                    <option value="<?= $year->annee ?>"><?= $year->annee ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="Form_footer">
                            <button class="Form_validate" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="Dropdown">
            <div class="Dropdown_item">
                Selectionner une autre liste
            </div>
            <div class="Dropdown_container">
                <?php foreach ($years as $year) : ?>
                    <div class="Dropdown_item" data-target="<?= $year->annee ?>">
                        <?= $year->annee ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php foreach ($years as $year) : ?>
            <div class="List js-tab js-tab-container <?= $i == 0 ? 'visible' : '' ?>" data-id="<?= $year->annee ?>">
                <div class="Form_title">
                    Liste des adhérents <?= $year->annee ?> <hr/>
                </div>

                <?php foreach ($groups as $group) : ?>
                    <?php if($group->annee == $year->annee): ?>
                        <p class="Table_title" id="<?= $group->groupe ?>" >
                            Groupe <?= $group->groupe ?>: <?= $group->number ?> <?= $field = ($group->number > 1) ? 'adhérents' : 'adhérent' ?>
                        </p>
                        <?php
                            // trie des adhérents par groupe
                            $user2 = array_filter($users, function ($user) use ($group) {
                                return ($user->groupe == $group->groupe);
                            });

                            // trie des adhérents par années
                            $user2 = array_filter($user2, function ($user) use ($year) {
                                return ($user->annee == $year->annee);
                            });
                        ?>
                        <table class="Table">
                            <?php $n = 0;
                            foreach ($user2 as $user) : $n++ ?>
                                <?= ($n % 2) ? '<tr class="even">' : '<tr class="odd">' ?>

                                <td class="Table_avatar"><img class="Table_picture" src='<?= $image->getImage($user->picture, "avatar"); ?>' alt=""></td>
                                <td class="Table_name"><?= $user->nom ?></td>
                                <td class="Table_name"><?= $user->prenom ?></td>
                                <td class="Table_group"><?= $user->groupe ?></td>
                                <td class="Table_notes">
                                    <?php if (!empty($user->tel1) && $user->tel1 != "") : ?>
                                        <span class="bold">tel1: </span> <?= $user->tel1 ?> <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->tel2) && $user->tel2 != "") : ?>
                                        <span class="bold">tel2: </span> <?= $user->tel2 ?>  <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->port1) && $user->port1 != "") : ?>
                                        <span class="bold">port1: </span>  <?= $user->port1 ?>  <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->port2) && $user->port2 != "") : ?>
                                        <span class="bold">port2: </span> <?= $user->port2 ?>  <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->email1) && $user->email1 != "") : ?>
                                        <br/>
                                        <span class="bold">email: </span> <a class="Table_link" href="mailto:<?= $user->email1 ?>"><?= $user->email1 ?> </a> <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->email2) && $user->email2 != "") : ?>
                                        <span class="bold">email2: </span><a class="Table_link" href="mailto:<?= $user->email2 ?>"> <?= $user->email2 ?> </a> <br/>
                                    <?php endif ?>
                                </td>
                                <td class="Table_notes">
                                    <span class="bold">Droit à l'image: </span> <?= $user->droitimage ?> <br/>
                                    <span class="bold">Certificat médical: </span><?= $user->certificat ?> <br/><br/>
                                    <span class="bold">Payé: </span><?= $user->paye ?> <br/>
                                    <span class="bold">Montant: </span><?= $user->montant ?> <br/>
                                </td>
                                <td class="Table_notes">
                                    <?php if (!empty($user->remarques) && $user->remarques != "") : ?>
                                        <span class="bold">Remarques:</span> <?= $user->remarques ?> <br/>
                                    <?php endif ?>
                                    <?php if (!empty($user->cotis) && $user->cotis != "") : ?>
                                        <span class="bold">Cotisation:</span> <?= $user->cotis ?>
                                    <?php endif ?>
                                </td>
                                <td class="Table_modify"><a class="Table_link" href="edit.php?id=<?= $user->id ?>">Modifier</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php $i++; ?>
        <?php endforeach ?>
    </div>
</div>

<script type="text/javascript" src="js/global.js"></script>

</body>
</html>
