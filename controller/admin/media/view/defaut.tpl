<h2>Médiathèque</h2>


<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.cookie.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="{$ENGINE_RESSOURCE}js/admin/jquery.jstree.js"></script>

<link rel="stylesheet" href="{$ENGINE_RESSOURCE}themes/admin/jsTree/default/style.css" type="text/css" media="screen" />



<div id="container">

<div id="mmenu" style="height:30px; overflow:auto;">
<input type="button" id="add_folder" value="add folder" style="display:block; float:left;"/>
<input type="button" id="add_default" value="add file" style="display:block; float:left;"/>
<input type="button" id="rename" value="rename" style="display:block; float:left;"/>
<input type="button" id="remove" value="remove" style="display:block; float:left;"/>
</div>

<form onsubmit="uploadFile();" name="form1" enctype="multipart/form-data" method="post" action="upload/" />
    <input type="file" size="32" name="new_media" value="" />
    <input type="hidden" name="action" value="simple" />
    <input type="hidden" name="node" id="nodeUpload" value="" />
    <input type="submit" name="Submit" value="upload" />
</form>
<br /><br />
<!-- the tree container (notice NOT an UL node) -->
<div id="mediatheque" class="mediatheque"></div>
<!-- JavaScript neccessary for the tree -->
{literal}
<script type="text/javascript">

function uploadFile(){
    var nodeID = jQuery('.jstree-clicked').parent().attr('id').replace("node_","")
    var nodeREL = jQuery('.jstree-clicked').parent().attr('rel');
    if(nodeREL != "folder")
        alert('Veuillez choisir un dossier');
    else
        jQuery('#nodeUpload').val(nodeID);
}

$(function () {
	// Settings up the tree - using $(selector).jstree(options);
	// All those configuration options are documented in the _docs folder
	$("#mediatheque")
		.jstree({
			// the list of plugins to include
			"plugins" : [ "themes", "json_data", "ui", "crrm", "cookies", "dnd", "types" ],
			// Plugin configuration

			// I usually configure the plugin that handles the data first - in this case JSON as it is most common
			"json_data" : {
				// I chose an ajax enabled tree - again - as this is most common, and maybe a bit more complex
				// All the options are the same as jQuery's except for `data` which CAN (not should) be a function
				"ajax" : {
					// the URL to fetch the data
					"url" : "data/",
					// this function is executed in the instance's scope (this refers to the tree instance)
					// the parameter is the node being loaded (may be -1, 0, or undefined when loading the root nodes)
					"data" : function (n) {
						// the result is fed to the AJAX request `data` option
						return {
							"operation" : "get_children",
							"id" : n.attr ? n.attr("id").replace("node_","") : 1
						};
					}
				}
			},
			// Using types - most of the time this is an overkill
			// Still meny people use them - here is how
			"types" : {
				// I set both options to -2, as I do not need depth and children count checking
				// Those two checks may slow jstree a lot, so use only when needed
				"max_depth" : -2,
				"max_children" : -2,
				// I want only `drive` nodes to be root nodes
				// This will prevent moving or creating any other type as a root node
				"valid_children" : [ "drive" ],
				"types" : {
					// The default type
					"default" : {
						// I want this type to have no children (so only leaf nodes)
						// In my case - those are files
						"valid_children" : "none"
						// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					},
					// The `folder` type
					"folder" : {
						// can have files and other folders inside of it, but NOT `drive` nodes
						"valid_children" : [ "default", "folder" ]
					},
					// The `drive` nodes
					"drive" : {
						// can have files and folders inside, but NOT other `drive` nodes
						"valid_children" : [ "default", "folder" ],
						// those options prevent the functions with the same name to be used on the `drive` type nodes
						// internally the `before` event is used
						"start_drag" : false,
						"move_node" : false,
						"delete_node" : false,
						"remove" : false
					}
				}
			},
			// For UI & core - the nodes to initially select and open will be overwritten by the cookie plugin

			// the UI plugin - it handles selecting/deselecting/hovering nodes
			"ui" : {
				// this makes the node with ID node_4 selected onload
				"initially_select" : [ "node_4" ]
			},
			// the core plugin - not many options here
			"core" : {
				// just open those two nodes up
				// as this is an AJAX enabled tree, both will be downloaded from the server
				"initially_open" : [ "node_2" , "node_3" ]
			}
		})
		.bind("create.jstree", function (e, data) {
			$.post(
				"data/create_node/",
				{
					"id" : data.rslt.parent.attr("id").replace("node_",""),
					"position" : data.rslt.position,
					"title" : data.rslt.name,
					"type" : data.rslt.obj.attr("rel")
				},
				function (r) {
					if(r.status) {
						$(data.rslt.obj).attr("id", "node_" + r.id);
					}
					else {
						$.jstree.rollback(data.rlbk);
					}
				}, "json"
			);
		})
		.bind("remove.jstree", function (e, data) {
			data.rslt.obj.each(function () {
				$.ajax({
					async : false,
					type: 'POST',
					url: "data/remove_node/",
					data : {
						"id" : this.id.replace("node_","")
					},
					success : function (r) {
						if(!r.status) {
							data.inst.refresh();
						}
					}
				});
			});
		})
		.bind("rename.jstree", function (e, data) {
			$.post(
				"data/rename_node/",
				{
					"id" : data.rslt.obj.attr("id").replace("node_",""),
					"title" : data.rslt.new_name
				},
				function (r) {
					if(!r.status) {
						$.jstree.rollback(data.rlbk);
					}
				}, "json"
			);
		});
});
</script>
<script type="text/javascript">
$(function () {
	$("#mmenu input").click(function () {
		switch(this.id) {
			case "add_default":
                  console.log(this);
            break;
			case "add_folder":
				$("#mediatheque").jstree("create", null, "last", { "attr" : { "rel" : this.id.toString().replace("add_", "") } });
				break;
			case "text": break;
			default:
				$("#mediatheque").jstree(this.id);
				break;
		}
	});
});
</script>
{/literal}

</div>
