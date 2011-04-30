<h2>Médiathèque</h2>


<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.cookie.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.jstree.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.nyroModal.custom.min.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.nyroModal.ie6.min.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/media.js"></script>

<link rel="stylesheet" href="{$ENGINE_RESSOURCE}themes/admin/jsTree/default/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$ENGINE_RESSOURCE}themes/admin/nyroModal/nyroModal.css" type="text/css" media="screen" />



    <div id="mmenu" style="overflow:auto;">
        <a id="rename" hreh="#" title="Renommer">Renommer</a>
        <a id="remove" hreh="#" title="Supprimer">Supprimer</a>
        <a id="add_folder" hreh="#" title="Ajouter un dossier">Ajouter un dossier</a>
        <a id="logo_upload" hreh="#" title="Envoyer un fichier">Envoyer un fichier</a>
        <a id="logo_uploadYT" hreh="#" title="Envoyer une vidéo Youtube">Envoyer une vidéo Youtube</a>
        <a id="info" href="#" title="Plus d'informations">Plus d'informations</a>
    </div>
    <div id="youtubeForm" class="form_opt"><div class="inner"></div></div>

    <form class="form_opt" id="uploadForm" onsubmit="uploadFile();" name="form1" enctype="multipart/form-data" method="post" action="upload/" />
        <input type="file" size="32" name="new_media" value="" />
        <input type="hidden" name="action" value="simple" />
        <input type="hidden" name="node" id="nodeUpload" value="" />
        <input type="submit" name="Submit" value="Envoyer" />
    </form>
    <br /><br />
    
    <!-- the tree container (notice NOT an UL node) -->
    <div id="mediatheque" class="mediatheque"></div>

