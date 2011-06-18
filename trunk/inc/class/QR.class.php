<?php



define('QR_FILE','phpqrcode/qrlib.php');

if(file_exists(FOLDER_CLASS_EXT.QR_FILE))
	include FOLDER_CLASS_EXT.QR_FILE;
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.QR_FILE))
	include ENGINE_URL.FOLDER_CLASS_EXT.QR_FILE;


/***
 * Générate QR CODE
 */
class QR extends QRcode{

    /*
     * Générate png QRcode
     */
    public static function png($text, $outfile = false, $level = 'L', $size = 8, $margin = 4, $saveandprint=false){
        parent::png($text, $outfile, $level, $size, $margin, $saveandprint);
    }

    
}

?>