<?php
if(isset($_POST) && !empty($_POST)){

$errors=array();

$validator = new Validator($_POST);


$validator->isEmpty('firstname', "Prénom");
$validator->isEmpty('lastname', "Nom");
$validator->isEmpty('birthdate', "Date de naissance");
$validator->isEmpty('email','Email');
$validator->isEmpty('adress', "Adresse");
$validator->isEmpty('group', "Groupe");
$validator->isEmpty('droit', "Droit à l'image");
$validator->isEmpty('certif', "Certificat médical");
$validator->isEmpty('paye', "Payé");


if($validator->isValid()){
    $db->query("INSERT INTO amjd2018 SET prenom = ?, nom= ?, datenaiss= ?, email1=?, 	adresse1 = ?, groupe = ?, droitimage = ?, certificat = ?, paye = ?", [
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['birthdate'],
        $_POST['email'],
        $_POST['adress'],
        $_POST['group'],
        $_POST['droit'],
        $_POST['certif'],
        $_POST['paye']
    ]);

    $id_adherent = $db->lastInsertId();

    function insert($post, $dbField, $lastid, $db){
      $input = $_POST[$post];

      if(!empty($input)) {
          $sql = "UPDATE amjd2018 SET $dbField = ? WHERE id= ?";
          $db->query($sql, [$input, $lastid]);
        }
      else {
        return;
      }
    }

    insert('lastname2', 'nom2',$id_adherent, $db);
    insert('adress2', 'adresse2',$id_adherent, $db);
    insert('cp', 'cp', $id_adherent, $db);
    insert('city', 'ville', $id_adherent, $db);
    insert('tel1', 'tel1', $id_adherent, $db);
    insert('tel2', 'tel2', $id_adherent, $db);
    insert('port1', 'port1', $id_adherent, $db);
    insert('port2', 'port2', $id_adherent, $db);
    insert('email2', 'email2', $id_adherent, $db);
    insert('remarques', 'remarques', $id_adherent, $db);
    insert('cotis', 'cotis', $id_adherent, $db);
    insert('montant', 'montant', $id_adherent, $db);

        if(!empty($_FILES['avatarToUpload'])){

            if($_FILES['avatarToUpload']["error"]==0){
                $image = new Image();
                $image = $image->uploadimg($_FILES['avatarToUpload'], "avatar");
                if($image){
                $db->query("UPDATE amjd2018 SET picture = ? WHERE id= ?",[$image, $id_adherent]);
                }
            }
        }

        header("Refresh:0");
    }else{
        $errors = $validator->getErrors();

    }
}

?>
