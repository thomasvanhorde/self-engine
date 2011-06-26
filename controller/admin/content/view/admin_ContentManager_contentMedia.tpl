<h2>Selectionnez un média</h2>

{capture name=sampleTpk}{$ENGINE_URL}controller/admin/media/view/sample.tpl{/capture}

<div id="mediaList">
    {foreach from=$mediaData->media key=k item=media}
        {if $media->attr->rel != 'drive' && $media->attr->rel != 'folder'}
            {include file=$smarty.capture.sampleTpk}
        {/if}
    {/foreach}
</div>

{literal}
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery.each( jQuery('#mediaList a'), function(k, v){
            var element = jQuery(v);
            var id = element.attr('id');

            element.click(function (){
                jQuery(mediaSelect).val(id);
                jQuery.nmTop().close();
                return false;
            });

         });
    });
</script>
{/literal}