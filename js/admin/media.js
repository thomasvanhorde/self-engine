var nodeID, nodeREL;

function uploadFile(){
    nodeID = jQuery('.jstree-clicked').parent().attr('id').replace("node_","");
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



    $('#mediatheque li a,#mediatheque li ins').live('click', function() {
        nodeREL = jQuery(this).parent().attr('rel');
        if(nodeREL == "folder") {
            generateYT_form();
        }
    });

    $('#mediatheque li a').live('click', function() {
        nodeREL = jQuery(this).parent().attr('rel');
     //   if(nodeREL != "folder") {
            nodeID = jQuery(this).parent().attr('id').replace("node_","");
            jQuery('#info')
                    .attr('href','get-preview/'+nodeID+'/')
                    .nyroModal();
     //   }
    });




    function generateYT_form(){
        tryDom = jQuery('.jstree-clicked').parent().attr('id');
        if(tryDom != undefined) {
            tryID = jQuery('.jstree-clicked').parent().attr('id').replace("node_","");
            if(tryID != undefined){
                var nodeREL = jQuery('.jstree-clicked').parent().attr('rel');
                if(nodeREL == 'folder'){
                    nodeId = tryID;

                    $.ajax({
                      url: "youtube-form/?nodeID="+nodeId,
                      success: function(data){
                        jQuery('#youtubeForm .inner').html(data);
                      }
                    });
                }else {
                    jQuery('#youtubeForm .inner').html('Veuillez choisir un dossier');
                }
            }
        }else
            jQuery('#youtubeForm .inner').html('Veuillez choisir un dossier');
    }

	$("#mmenu a").click(function () {
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


    jQuery('#logo_upload').click(function (){
        jQuery('.form_opt').hide();
        jQuery('#uploadForm').fadeIn();
    });

    jQuery('#logo_uploadYT').click(function (){
        jQuery('.form_opt').hide();
        if(nodeID == undefined){
            jQuery('#youtubeForm .inner').html('<span class="ucLoader"></span>');
            generateYT_form();
        }
        jQuery('#youtubeForm').fadeIn();
    });


    jQuery('#info').click(function (){
        if(nodeREL != "folder") {
            nodeID = jQuery('.jstree-clicked').parent().attr('id').replace("node_","");
        }
    });

    jQuery.each(jQuery('#mediatheque li.jstree-open'), function(i, l){
        jQuery(l).removeClass('jstree-open').addClass('jstree-closed');
    });


});