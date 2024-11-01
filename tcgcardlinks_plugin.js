// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.mygallery', {
		// creates control instances based on the control's id.
		// our button's id is "mygallery_button"
		createControl : function(id, controlManager) {
			if (id == 'mygallery_button') {
				// creates the button
				var button = controlManager.createButton('mygallery_button', {
					title : 'MtG Card Shortcode', // title of the button
					//image : '../wp-includes/images/smilies/icon_mrgreen.gif', 
					image : '../wp-content/plugins/tcg-card-links/tcg_icon.gif',
					
					// path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'MtG Card Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mygallery-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('mygallery', tinymce.plugins.mygallery);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="mygallery-form"><table id="mygallery-table" class="form-table">\
			<tr>\
				<th><label for="mygallery-cardname">Card Name</label></th>\
				<td><input type="text" id="mygallery-cardname" name="cardname" value="" /><br />\
				<small>specify the card name. It is mandatory</small></td>\
			</tr>\
			<tr>\
				<th><label for="mygallery-setname">Set Name</label></th>\
				<td><input type="text" name="setname" id="mygallery-setname" value="" /><br />\
				<small>specify the set name. <a href="http://edhblog.com/mtg-set-names/" target="_blank">Set Name Reference</a></small></td>\
			</tr>\
			<tr>\
				<th><label for="mygallery-cardtype">Card Type</label></th>\
				<td><select name="cardtype" id="mygallery-cardtype">\
					<option value="magic">Magic</option>\
				</select><br />\
				<small>specify the card type.</small></td>\
			</tr>\
			<tr>\
				<th><label for="mygallery-linktext">Link Text</label></th>\
				<td><input type="text" name="linktext" id="mygallery-linktext" value="" /><br />\
				<small>specify the link text.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="mygallery-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#mygallery-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'cardname'    : '',
				'setname'     : '',
				'cardtype'    : 'magic',
				'linktext'    : ''
				};
			var shortcode = '[mtg';
			
			for( var index in options) {
				var value = table.find('#mygallery-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()