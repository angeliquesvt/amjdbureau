<?php

class Image {

    /**
     *
     * @param type $file
     * @param type $chemin
     * @return boolean
     */
    public function uploadimg($file, $chemin) {
      if($file["size"]>=2097152){
        $session = new Session();
        $session->setFlash("danger", "Le poids de votre image est trop important");
          return null;
      }
      if($file["error"]>0){
        $session = new Session();
        $session->setFlash("danger", "Votre image n'a pas pu être téléchargée");
          return null;
      }

        $target_dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $chemin . DIRECTORY_SEPARATOR;
        $filename = strtolower($file["name"]);
         $target_file = $target_dir . basename($filename);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (file_exists($target_file)) {
            $filename = Str::random(10) . $file["name"];
        }
        if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if (move_uploaded_file($file["tmp_name"], $target_dir.$filename)) {
                return $filename;
            }
        } else {
            $session = new Session();
            $session->setFlash("danger", "Le format est invalide");
            return null;
        }
    }

    public function getImage($fileName, $chemin, $imgDefault="avatar.png"){
      $path ="img/". $chemin ."/";
      $target_dir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $chemin . DIRECTORY_SEPARATOR;

      if(is_file($target_dir.$fileName)){
        echo $path.$fileName;

      }else{
        echo $path.$imgDefault;
      }
    }
}
