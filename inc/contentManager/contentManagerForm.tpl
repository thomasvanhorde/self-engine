<!-- Auto form -->
{strip}
{if $formCompteur == 1}
<link rel="stylesheet" href="{ $ENGINE_RESSOURCE}themes/admin/niceforms/niceforms-default.css" type="text/css" media="screen">
<script type="text/javascript">var ENGINE_RESSOURCE = "{$ENGINE_RESSOURCE}";</script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}/js/admin/datepicker/datepicker.packed.js"></script>

<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.nyroModal.custom.min.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.nyroModal.ie6.min.js"></script>

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.9.0/build/assets/skins/sam/skin.css"> 
<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.9.0/build/yahoo-dom-event/yahoo-dom-event.js&2.9.0/build/animation/animation-min.js&2.9.0/build/element/element-min.js&2.9.0/build/container/container-min.js&2.9.0/build/menu/menu-min.js&2.9.0/build/button/button-min.js&2.9.0/build/editor/editor-min.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/engine/yui.wysiwyg.js"></script>

<link rel="stylesheet" href="{$ENGINE_RESSOURCE}themes/admin/nyroModal/nyroModal.css" type="text/css" media="screen" />
{/if}

<form method="post" class="validity niceform yui-skin-sam" id="form_{$formUID}">
    <fieldset>
        <legend>
            {if $id==''}
                Nouveau contenu { $structure->name }
            {else}
                Edition de contenu { $structure->name }
            {/if}
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
                                {if $element->requis}*{/if}
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
                            <textarea {if $hidden}style="display:none;"{/if} rows="20" cols="100" class="{if $element->requis}require{/if} yui_wysiwyg noNiceForm" id="{$uid}_editor">{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}</textarea>

                            <div style="position:absolute;top:-1000px;">
                                <textarea {if $hidden}style="display:none;"{/if} rows="20" cols="100" class="{if $element->requis}require{/if} " id="{$uid}" name="{$uid}" >{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}</textarea>
                            </div>
                            <div class="">
                            <script type="text/javascript">
                                var myEditor_{$uid} = new YAHOO.widget.Editor('{$uid}_editor', wysiwygConfig);

                                myEditor_{$uid}{literal}.on('toolbarLoaded', function() {
                                    this.toolbar.on('insertimageClick', function() {
                                        var _sel = this._getSelectedElement();
                                        //If the selected element is an image, do the normal thing so they can manipulate the image
                                        if (_sel && _sel.tagName && (_sel.tagName.toLowerCase() == 'img')) {
                                        } else {
                                            win = window.open({/literal}'{$SYS_FOLDER}admin/content-manager/contenus/get-media-rte/{$uid}_editor'{literal}, 'IMAGE_BROWSER',
                                                'left=20,top=20,width=500,height=500,toolbar=0,resizable=0,status=0');
                                            if (!win) {
                                                alert('La fenêtre à été bloqué, desactivez le blocage');
                                            }
                                            //This is important.. Return false here to not fire the rest of the listeners
                                            return false;
                                        }
                                    }, this, true);
                                }, {/literal}myEditor_{$uid}, true);
                                myEditor_{$uid}{literal}.on('afterOpenWindow', function() {
                                    var url = Dom.get(myEditor.get('id') + '_insertimage_url');
                                    if (url) {
                                        url.disabled = true;
                                    }
                                }, {/literal}myEditor_{$uid}{literal}, true);

                                YAHOO.util.Event.on({/literal}"form_{$formUID}", "submit", onReviewSubmit_{$uid}{literal});
                                function {/literal}onReviewSubmit_{$uid}{literal}(p_oEvent) { jQuery('#{/literal}{$uid}{literal}').val({/literal}myEditor_{$uid}{literal}.getEditorHTML()); }
                                {/literal}myEditor_{$uid}{literal}.render();
                            </script>
                            {/literal}
                            </div>
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
                            <div {if $hidden}style="display:none;"{/if} class="media">
                                <input class="hidden {if $element->requis}require{/if}" type="text" name="{$uid}" value="{$data->$uid}{if $valueDefaut != false}{$valueDefaut}{/if}"/>
                            </div>
                            <a href="{$SYS_FOLDER}admin/content-manager/contenus/get-media" class="mediaSelect">Select</a>
                            <div id="media_apercu_{$uid}"></div>
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

    <div style="clear:both;"><strong>*</strong> Obligatoire</div>

    </fieldset>

    <input type="submit" name="submit" id="submit" value="enregistrer" />



</form>



{if $formCompteur == 1}
    <script type="text/javascript" src="{$ENGINE_RESSOURCE}js/engine/jquery.validity.pack.js"></script>
    <script type="text/javascript" src="{$ENGINE_RESSOURCE}js/engine/niceforms.js"></script>
{/if}

{literal}
    <script>
        var mediaSelect = null;
        var niceFormID = 'form_{/literal}{$formUID}{literal}';
        jQuery(function() {
            jQuery("form#form_{/literal}{$formUID}{literal}.validity").validity(function() {
                jQuery("form#form_{/literal}{$formUID}{literal} .require").require('necessaire');
                jQuery("form#form_{/literal}{$formUID}{literal} .email").match("email");
                jQuery("form#form_{/literal}{$formUID}{literal} .number").match("number");
            });


        jQuery('.mediaSelect')
                .nyroModal()
                .click(function(){
                     mediaSelect = jQuery(this).parent().find('input');
                });

        jQuery('.hidden').parents('.media').hide();

        });
    </script>

<style>
    .yui-toolbar-group-undoredo h3, .yui-toolbar-group-insertitem h3, .yui-toolbar-group-indentlist h3 {
    width: 100px;
}
</style>
{/literal}



{/strip}