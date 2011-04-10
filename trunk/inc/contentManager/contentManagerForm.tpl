<!-- Auto form -->
{strip}
{if $formCompteur == 1}
<script type="text/javascript" src="{$BASE_URL}/js/admin/datepicker/datepicker.packed.js"></script>
{/if}

<form method="post" class="validity niceform" id="form_{$formUID}">
    <fieldset>
        <legend>
            {if $id==''}
                Nouveau contenu
            {else}
                Edition de contenu
            {/if}
            { $structure->name }
        </legend>

        {assign var="strucId" value=$structure.id}
        <input type="hidden" name="todo" value="{$action}" />
        <input type="hidden" name="collection" value="{$strucId }" />
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="date_create" value="{$data->date_create}" />

        {assign var="formParamFied" value=$formParam.field}

        {foreach from=$structure->types key=tmp item=e}
            {foreach from=$e key=k item=element}

                {assign var="uid" value=$element->id}
                {assign var="refT" value=$element.refType}
                {assign var="hidden" value=false}
                {assign var="valueDefaut" value=false}

                {* PARAMETRES *}
                {foreach from=$formParamFied key=fieldKeys item=fieldValues}
                    {if $fieldKeys == $uid}
                    {foreach from=$fieldValues key=filedKey item=fieldValue}

                        {* champs invisible *}
                        {if $filedKey == 'hidden' && $fieldValue == true}
                            {assign var="hidden" value=true}
                        {/if}

                        {* defaut value *}
                        {if $filedKey == 'value'}
                            {assign var="valueDefaut" value=$fieldValue}
                        {/if}

                    {/foreach}
                    {/if}
                {/foreach}
                {* /PARAMETRES *}


                <dl class="{if $hidden == true}hidden{else}visible{/if}">

                    {if $hidden == false}
                        <dt>
                            <label for="{$uid}">
                                {$element->name}
                                {if $element->limit != '' }(limit :: {$element->limit} char){/if}
                            </label>
                        </dt>
                    {/if}
                    
                    <dd>
                        {* Input *}
                        {if $refT == '10'}
                            <input {if $hidden}style="display:none;"{/if} class="{if $element->requis}require{/if}" type="text" name="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}" { if $element->limit != '' }maxlength="{$element->limit}"{/if}/>
                        {/if }

                        {* Input password *}
                        {if $refT == '11'}
                            <input {if $hidden}style="display:none;"{/if} class="{if $element->requis}require{/if}" type="password" name="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}" { if $element->limit != '' }maxlength="{$element->limit}"{/if}/>
                        {/if }

                        {* Input email *}
                        {if $refT == '12'}
                            <input {if $hidden}style="display:none;"{/if} class="email {if $element->requis}require{/if}" type="text" name="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}" { if $element->limit != '' }maxlength="{$element->limit}"{/if}/>
                        {/if }

                        {* Input number *}
                        {if $refT == '13'}
                            <input {if $hidden}style="display:none;"{/if} class="number {if $element->requis}require{/if}" type="text" name="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}" { if $element->limit != '' }maxlength="{$element->limit}"{/if}/>
                        {/if }

                        {* Checkbox *}
                        {if $refT == '15'}
                            <input {if $hidden}style="display:none;"{/if} class="{if $element->requis}require{/if}"name="{$uid}" {if $data->$uid == "true"}checked="checked"{/if} value="true" type="checkbox"/>
                        {/if }

                        {* textarea simple *}
                        {if $refT == '20'}
                            <textarea {if $hidden}style="display:none;"{/if} rows="5" cols="60" class="{if $element->requis}require{/if}" id="{$uid}" name="{$uid}">{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}</textarea>
                        {/if }

                        {* textarea wysiwyg *}
                        {if $refT == '21'}
                            <textarea {if $hidden}style="display:none;"{/if} rows="5" cols="60" class="{if $element->requis}require{/if}" id="{$uid}" name="{$uid}" id="{$uid}" class="wysiwyg">{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}</textarea>
                        {/if }

                        {* date *}
                        {if $refT == '30'}

                        <input {if $hidden}style="display:none;"{/if} type="text" class="date w16em {if $element->requis}require{/if}" name="{$uid}" id="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}" />

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

                        {* media *}
                        {if $refT == '40'}
                            // media :: not implemante
                        {/if }

                        {* select *}
                        {if $refT == '50'}
                            {assign var=SelectValue value=","|explode:$element->valeur}
                            <select {if $hidden}style="display:none;"{/if} size="1" class="{if $element->requis}require{/if}" name="{$uid}">
                                {foreach from=$SelectValue key=SelectK item=SelectItem}
                                    <option value="{$SelectK}" {if $data->$uid == $SelectK || $valueDefaut == $SelectK}selected="selected"{/if}>{$SelectItem}</option>
                                {/foreach}
                            </select>
                        {/if }

                        {* ContentRef *}
                        {if $refT == '60'}
                            {assign var="ElementContentRef" value=$element->contentRef}
                            <select {if $hidden != false}style="display:none;"{/if} size="1" class="{if $hidden}hidden {/if}{if $element->requis}require{/if}" name="{$uid}">
                                <option value=""></option>
                                {foreach from=$contentRef key=contentRefId item=contentRefElement}
                                    {if $contentRefId == $ElementContentRef}
                                        {foreach from=$contentRefElement key=contentRefId2 item=contentRefElement2}
                                            <option {if $contentRefId2 == $data->$uid->_id || $valueDefaut == $contentRefId2}selected="selected" {/if} value="{$contentRefId2}">
                                                {foreach from=$contentRefElement2 key=contentRefId3 item=contentRefElement3}
                                                    {foreach from=$contentRefStruct key=contentRefStructID item=contentRefStruct2}
                                                        {if $contentRefStructID == $ElementContentRef}
                                                            {if $contentRefStruct2.$contentRefId3->index == "true"}
                                                                {$contentRefElement3}
                                                            {/if}
                                                        {/if}
                                                    {/foreach}
                                                {/foreach}
                                            </option>
                                        {/foreach}
                                    {/if}
                                {/foreach}
                            </select>
                        {/if }

                        
                    </dd>
                </dl>
            {/foreach}
        {/foreach}


    </fieldset>

    <input type="submit" name="submit" id="submit" value="enregistrer" />



</form>



{if $formCompteur == 1}
    <script type="text/javascript" src="{$BASE_URL}js/engine/jquery.validity.pack.js"></script>
    <script type="text/javascript" src="{$BASE_URL}js/engine/niceforms.js"></script>
{/if}

{literal}
    <script>
        var niceFormID = 'form_{/literal}{$formUID}{literal}';
        jQuery(function() {
            jQuery("form#form_{/literal}{$formUID}{literal}.validity").validity(function() {
                jQuery("form#form_{/literal}{$formUID}{literal} .require").require('necessaire');
                jQuery("form#form_{/literal}{$formUID}{literal} .email").match("email");
                jQuery("form#form_{/literal}{$formUID}{literal} .number").match("number");
            });

        });
    </script>
{/literal}

{/strip}