<div style="width:515px;">

    <h2>Edition - {$media->attr->rel}</h2>


    {switch $media->attr->rel}
        {case 'image/jpeg'}
        {case 'image/png'}
            <a href="{$SYS_FOLDER}{$media->file->url}" target="_blank" title="Voir l'original">
                <h3>{$media->data}</h3>
                {thumb file=$media->file->url height="50" link="false"}
            </a>
        {break}
        {case 'application/pdf'}
            <a href="{$SYS_FOLDER}{$media->file->url}" target="_blank" title="Voir le pdf">
                <h3>{$media->data}</h3>
                lire le pdf
            </a>
        {break}
    {/switch}

    <br /><br />

    <form method="post">
        <input type="hidden" name="todo" value="edit" />
        <input type="hidden" name="nodeID" value="{$media->attr->id}" />
        <label for="description"><strong>Description</strong></label>
        <textarea style="width: 500px; height: 120px;" id="description" name="data[description]">{$media->description}</textarea>
        <br /><br />
        <input type="submit" value="enregistrer" style="float: right;"/>
        <br /><br />
    </form>

</div>