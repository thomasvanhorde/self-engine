<?php
/**
 * User: Thomas
 * Date: 15/03/11
 * Time: 16:09
 */

/***
 * DOC
 * http://wiki.spipu.net/doku.php?id=html2pdf:fr:v4:accueil
 */

if(file_exists(FOLDER_CLASS_EXT.'html2pdf_v4.01/html2pdf.class.php'))
	require_once FOLDER_CLASS_EXT.'html2pdf_v4.01/html2pdf.class.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'html2pdf_v4.01/html2pdf.class.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'html2pdf_v4.01/html2pdf.class.php';
else
    Base::Load(CLASS_CORE_MESSAGE)->Warning('ERR_LOAD_CLASS_PDF');


class Pdf extends HTML2PDF{
    public function simplePDF($template, $fileName = 'exemple.pdf', $output = 'D'){
        $content = Base::Load(CLASS_COMPONENT)->_view->addBlock('pdf_generate',$template);
        $this->WriteHTML($content);
        $this->Output($fileName, $output);
        exit();
    }
}
