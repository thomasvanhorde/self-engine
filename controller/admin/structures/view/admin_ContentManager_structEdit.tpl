{if $locked == 'true' && $clone != 'true' }
    Structure verrouiller
{else }

{if $clone == 'true' }<h3>Edition d'un clone de { $struct.name }</h3>{/if }
<form method="post" {if $clone == 'true' }action="../../"{/if } >
    <input type="hidden" name="todo" value="admin/structures[structEdit]" />
    <input type="hidden" name="id" value="{if $clone != 'true' }{ $structID }{else }{/if }"/>

    
    <label>Nom</label><input name="name" type="text" value="{ $struct.name }{if $clone == 'true' } - clone{/if }" />
    <label>Description</label><textarea name="description">{ $struct.description }</textarea>

    <strong>Elements</strong>

    <table id="StructList">

        <tr> 
            <th>Label</th>
            <th>ID</th>
            <th>Type</th>
            <th>Valeur(s)</th>
            <th>Limite</th>
            <th>Requis</th>
            <th>Index</th>
            <th></th>
        </tr>
        
        {assign var=k value=0}
        {foreach from=$struct.data key=k item=element}
            <tr>
                <td>
                    <input type="text" name="data[{$k}][name]" value="{ $element.type.name }" />
                </td>
                <td>
                    <input type="text" name="data[{$k}][id]" value="{ $element.type.id }""/>
                </td>
                <td>
                    <select class="type" name="data[{$k}][type]" onchange="changeType()">
                    {foreach from=$typeList key=kType item=type}
                        {if $element.structId == $kType }
                        <option value="{ $kType }" selected="selected">{ $type }</option>
                        {/if}
                        {if $element.structId != $kType }
                        <option value="{ $kType }">{ $type }</option>
                        {/if}
                    {/foreach}
                    </select>
                    <div style="display:none;">
                        <select name="data[{$k}][contentRef]">
                            <option value="">Structure</option>
                            {foreach from=$strucList key=KStruct item=Struct}
                                {if $Struct.locked == "false"}
                                    <option value="{$KStruct}" {if $element.type.contentRef == $KStruct }selected="selected" {/if}>{$Struct.name}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </td>
                <td>
                    <input class="valeur" type="text" name="data[{$k}][valeur]" value="{ $element.type.valeur }"/>
                    <div>{if $element.structId == 50 }séparé par ","{/if}</div>
                </td>
                <td>
                    <input class="limit" type="text" name="data[{$k}][limit]" value="{ $element.type.limit }" maxlength="3" size="3"/>
                </td>
                <td>
                    <input class="requis" type="checkbox" name="data[{$k}][requis]" value="true" { if $element.type.requis =="true" }checked="checked"{/if} />
                </td>
                <td>
                    <input class="index" type="checkbox" name="data[{$k}][index]" value="true" { if $element.type.index =="true" }checked="checked"{/if} />
                </td>
                <td>
                    <a href="admin_ContentManager_structEdit.tpl#" onclick="deleteElement(this);return false;">x</a>
                </td>
            </tr>
        {/foreach}
    </table>


    <input type="button" value="Ajouter un champ" onclick="addElement();"/>

    <br /><br />
    <input type="submit" name="register" value="Enregistrer" /> 

</form>

<table id="elementList" style="display:none;">
    <tr class="elementListAdd" style="display:none;">
        <td>
            <input type="text" nameTmp="data[keyId][name]" />
        </td>
        <td>
            <input type="text" nameTmp="data[keyId][id]" value=""/>
        </td>
        <td>
            <select class="type" nameTmp="data[keyId][type]" onchange="changeType()">
                {foreach from=$typeList key=kType item=type}
                    <option value="{ $kType }">{ $type }</option>
                {/foreach}
            </select>
            <div style="display:none;">
                <select nameTmp="data[keyId][contentRef]">
                    <option value="">Structure</option>
                    {foreach from=$strucList key=KStruct item=Struct}
                        {if $Struct.locked == "false"}
                            <option value="{$KStruct}">{$Struct.name}</option>
                        {/if}
                    {/foreach}
                </select>
            </div>
        </td>
        <td>
            <input class="valeur" type="text" nameTmp="data[keyId][valeur]" value=""/>
            <div></div>
        </td>
        <td>
            <input class="limit" type="text" nameTmp="data[keyId][limit]" maxlength="3" size="3" />
        </td>
        <td>
            <input class="requis" type="checkbox" nameTmp="data[keyId][requis]" value="true" />
        </td>
        <td>
            <input class="index" type="checkbox" nameTmp="data[keyId][index]" value="true" />
        </td>
        <td>
            <a href="admin_ContentManager_structEdit.tpl#" onclick="deleteElement(this);return false;">x</a>
        </td>        
    </tr>
</table> 

        <script type="text/javascript">
            var kE = {$k};   // Last keyID
{literal}
            function addElement(){
                kE++;
                ElemenList = jQuery('#elementList tr');
                clone = ElemenList.clone();
                jQuery('#StructList').append(clone);
                jQuery('#StructList').find('tr:last-child').fadeIn();
                jQuery.each(jQuery('#StructList').find('tr:last-child').find('input, select'), function(i, item){
                    name = jQuery(item).attr('nameTmp').replace("keyId", kE);
                    jQuery(item).attr('name', name).removeAttr('nameTmp');
                });
            }

            function deleteElement(elem){
                jQuery(elem).parents('tr').fadeOut(400, function(){ jQuery(this).remove()});
            }

            function changeType(){
                chmpTxt = jQuery('#StructList tr select.type');
                jQuery.each(chmpTxt, function(i, item){
                    eLimit = jQuery(item).parents('tr').find('.limit');
                    eValue = jQuery(item).parents('tr').find('.valeur');
                    eIndex = jQuery(item).parents('tr').find('.index');
                    eType = jQuery(item).parents('tr').find('.type');
                    eValueDescr = eValue.parent().find('div');
                    eTypeDetail = eType.parent().find('div');
                    eTypeDetailSelect = eTypeDetail.find('select');
                   val = item.value;

                   if(val == 10)
                        eLimit.removeAttr('disabled');
                   else
                        eLimit.val('').attr('disabled', 'disabled');

                   if(val == 50)
                        eValueDescr.html('séparé par ","');
                    else
                        eValueDescr.html('');

                    if(val == 60)
                         eValue.val('').attr('disabled', 'disabled');
                    else
                         eValue.removeAttr('disabled');

                    if(val == 60) {
                         eTypeDetail.fadeIn();
                        eIndex.attr('disabled','disabled');
                    }
                    else {
                         eTypeDetail.hide();
                        eTypeDetailSelect.find('option').removeAttr('selected');
                        eTypeDetailSelect.val('');
                        eIndex.removeAttr('disabled');
                    } 


                 });
            }
            changeType();
        </script>
    {/literal}
{/if }