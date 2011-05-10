{literal}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>YUI: Editor Image Browser</title>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/reset-fonts-grids/reset-fonts-grids.css">
    <style type="text/css" media="screen">
    #doc {
        min-width: 500px;
        width: 90%;
    }
    #images p {
        float: left;
        padding: 3px;
        margin: 3px;
        border: 1px solid black;
        height: 100px;
        width: 100px;
        cursor: pointer;
    }

    #images img {height:50px;}
    </style>
</head>
</head>
<body class="yui-skin-sam">
<div id="doc" class="yui-t7">
<div id="images">
{/literal}
    {foreach from=$mediaData->media key=k item=media}
        {switch $media->attr->rel}
            {case 'image/jpeg'}
            {case 'image/png'}
            <img alt="{$media->data}" src="{$SYS_FOLDER}{$media->file->url}" />
            {break}
        {/switch}

    {/foreach}
{literal}
</div>
</div>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript">
(function() {
    var Dom = YAHOO.util.Dom,
        Event = YAHOO.util.Event,
        myEditor = window.opener.YAHOO.widget.EditorInfo.getEditorById({/literal}'{$elementID}'{literal});
        //Get a reference to the editor on the other page

    //Add a listener to the parent of the images
    Event.on('images', 'click', function(ev) {
        var tar = Event.getTarget(ev);
        //Check to see if we clicked on an image
        if (tar && tar.tagName && (tar.tagName.toLowerCase() == 'img')) {
            //Focus the editor's window
            myEditor._focusWindow();
            //Fire the execCommand for insertimage
            myEditor.execCommand('insertimage', tar.getAttribute('src', 2));
            //Close this window
            window.close();
        }
    });
    //Internet Explorer will throw this window to the back, this brings it to the front on load
    Event.on(window, 'load', function() {
        window.focus();
    });
})();
</script>
</body>
</head>
<!-- p5.ydn.re1.yahoo.com compressed/chunked Tue May 10 07:43:58 PDT 2011 -->
{/literal}