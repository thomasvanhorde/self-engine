{switch $media->attr->rel}
    {case 'image/jpeg'}
    {case 'image/jpg'}
    {case 'image/png'}
    {case 'image/gif'}
        <a href="{$SYS_FOLDER}{$media->file->url}" target="_blank" id="{$media->attr->id}" title="Voir l'original">
            <h3>{$media->data}</h3>
            {thumb file=$media->file->url height="50" link="false"}
        </a>
    {break}
    {case 'application/pdf'}
        <a href="{$SYS_FOLDER}{$media->file->url}" target="_blank" id="{$media->attr->id}" title="Voir le pdf">
            <h3>{$media->data}</h3>
        </a>
    {break}
{/switch}

{if $media->file->dataYoutube}
    <a href="http://www.youtube.com/watch?v={$media->file->dataYoutube->id}" target="_blank" id="{$media->attr->id}" title="Voir la vidéo">
    <h3>{$media->data}</h3>
    {foreach from=$media->file->dataYoutube->pictures item=pic key=k}
        {if $pic->height == '90' && $k >= 2 }
            <img alt="Image {$k}" src="{$pic->url}" />
        {/if}
    {/foreach}
    </a>
{/if}