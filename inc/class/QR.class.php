<?php

define('QR_FILE', 'phpqrcode/qrlib.php');

if (file_exists(FOLDER_CLASS_EXT.QR_FILE))
    include FOLDER_CLASS_EXT.QR_FILE;
elseif (file_exists(ENGINE_URL.FOLDER_CLASS_EXT.QR_FILE))
    include ENGINE_URL.FOLDER_CLASS_EXT.QR_FILE;

/**
 * QRcode generation.
 */
class QR extends QRcode
{
    /**
     * PNG generation.
     */
    public static function png($text, $outfile = false, $level = 'L', $size = 8, $margin = 4, $saveandprint = false)
    {
        parent::png($text, $outfile, $level, $size, $margin, $saveandprint);
    }
}

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  Not really useful if it is only used for our isolated case in "macrise".
  Otherwise, I suggest:

  $qrcodePngCreation = function ($text, $outfile = false, etc...) {
    QRcode::png($text, $outfile, $level, $size, $margin, $saveAndPrint);
  };
----------------------------------------------------------------------------- */