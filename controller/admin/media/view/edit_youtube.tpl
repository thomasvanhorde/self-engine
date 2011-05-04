<h2>Edition - vidéo <span style="color:red;">YouTube</span></h2>

<a href="http://www.youtube.com/watch?v={$media->file->dataYoutube->id}" target="_blank" title="voir la vidéo">
    <h3>{$media->data}</h3>
</a>

<div style="height: 90px; width: 380px;">
    {foreach from=$media->file->dataYoutube->pictures item=pic key=k}
        {if $pic->height == '90' && $k >= 2 }
            <img alt="Image {$k}" src="{$pic->url}" />
        {/if}
    {/foreach}
</div>

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
