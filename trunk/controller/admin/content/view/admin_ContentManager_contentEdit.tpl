<h3>Nouveau contenu { $struct.name }</h3>


<form method="post">
    <input type="hidden" name="todo" value="admin/content[contentEdit]" />
    <input type="hidden" name="collection" value="{ $struct.id }" />
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="date_create" value="{$data.date_create}" />
    {foreach from=$struct.types key=k item=element}

        {assign var="uid" value=$element.id}

        <br /><br /><br />
        {$element.name}
        { if $element.limit != '' }(limit :: {$element.limit} char){/if}
        <br /><br />

        <!-- Input -->
        {if $element.refType == '10'}
            <input type="text" name="{$uid}" value="{$data.$uid}" { if $element.limit != '' }maxlength="{$element.limit}"{/if}/>
        {/if }

        <!-- Input password -->
        {if $element.refType == '11'}
            <input type="password" name="{$uid}" value="{$data.$uid}" { if $element.limit != '' }maxlength="{$element.limit}"{/if}/>
        {/if }

        <!-- Input email -->
        {if $element.refType == '12'}
            <input class="email" type="text" name="{$uid}" value="{$data.$uid}" { if $element.limit != '' }maxlength="{$element.limit}"{/if}/>
        {/if }

        <!-- Input number -->
        {if $element.refType == '13'}
            <input class="number" type="text" name="{$uid}" value="{$data.$uid}" { if $element.limit != '' }maxlength="{$element.limit}"{/if}/>
        {/if }

        <!-- Checkbox -->
        {if $element.refType == '15'}
            <input name="{$uid}" {if $data.$uid == "true"}checked="checked"{/if} value="true" type="checkbox"/>
        {/if }

        <!-- textarea simple -->
        {if $element.refType == '20'}
            <textarea name="{$uid}">{$data.$uid}</textarea>
        {/if }

        <!-- textarea wysiwyg -->
        {if $element.refType == '21'}
            <textarea name="{$uid}" class="wysiwyg">{$data.$uid}</textarea>
        {/if }

        <!-- date -->
        {if $element.refType == '30'}

        <input type="text" class="w16em" id="{$uid}" name="{$uid}" value="{$data.$uid}" />

        {literal}
          <script type="text/javascript">
          // <![CDATA[
            var opts = {
                    formElements:{"{/literal}{$uid}{literal}":"y-sl-m-sl-d"},
                    // Show week numbers
                    showWeeks:true
            };
            datePickerController.createDatePicker(opts);
          // ]]>
          </script>
        {/literal}

        {/if }

        <!-- media -->
        {if $element.refType == '40'}
            // media :: not implemante
        {/if }

        <!-- select -->
        {if $element.refType == '50'}
            {assign var=SelectValue value=","|explode:$element.valeur}
            <select name="{$uid}">
                {foreach from=$SelectValue key=SelectK item=SelectItem}
                    <option value="{$SelectK}" {if $data.$uid == $SelectK}selected="selected"{/if}>{$SelectItem}</option>
                {/foreach}
            </select>
        {/if }

        <!-- ContentRef -->
        {if $element.refType == '60'}
            {assign var="El" value=$element.contentRef}
            {assign var="IndexEl" value=$index.$El}

            <select name="{$uid}">
                <option value=""></option>
                {foreach from=$IndexEl key=kIndex item=dateItem}
                    <option value="{$kIndex}" {if $data.$uid == $kIndex}selected="selected"{/if}>{$dateItem}</option>
                {/foreach}
            </select>
        {/if }
    
    {/foreach}

    <br /><br /><br />
    <input type="submit" value="enregistrer" />

</form>