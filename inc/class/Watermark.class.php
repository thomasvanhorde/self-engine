<?php

/**
 * Class permettant d'ajouter un watermark au photo
 * <img src="{$SYS_FOLDER}media/watermark/generate/{$img->url|base64_encode}" />
 *
 * Si l'image n'existe pas, elle est générer par la class,
 * dans le cas contraire, le fichier est appelé directement sans passer par la class
 */
class Watermark {

    const quality = 90;
    const watermark = 'media/watermark/logo.png';

    public function __construct(){}

    public function generate($src){

        if(preg_match('/.jpg/',$src))
            $src = substr($src, 0, -4);
        
        $src = base64_decode($src);


        header('Content-type: image/jpeg');
        $imgUrl = "media/watermark/generate/".base64_encode($src).'.jpg';

        //this will prevent the watermark from showing up in the thumbnail images
        $watermark = imagecreatefrompng(self::watermark);

        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image = imagecreatetruecolor($watermark_width, $watermark_height);
        if(preg_match('/.gif/',$src)) {
            $image = imagecreatefromgif($src);
        }
        elseif(preg_match('/.jpeg/',$src)||preg_match('/.jpg/',$src)) {
            $image = imagecreatefromjpeg($src);
        }
        elseif(preg_match('/.png/',$src)) {
            $image = imagecreatefrompng($src);
        }
        else {
            exit("Your image is not a gif, jpeg or png image. Sorry.");
        }
        $size = getimagesize($src);
        $dest_x = $size[0] - $watermark_width - 0;
        $dest_y = $size[1] - $watermark_height - 0;
        imagecolortransparent($watermark,imagecolorat($watermark,0,0));
        imagecopyresampled($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
        imagejpeg($image, $imgUrl, self::quality);
        imagejpeg($image, '', self::quality);


        imagedestroy($image);
        imagedestroy($watermark);

    }
}

