(function() {
	tinymce.PluginManager.add( 'moremenu', function( editor ){
		
		var items = [];

        items.push({
            text: 'HH',
            onclick: function(){}
        });

		editor.addButton( 'moremenubtn', {
			type: 'menubutton',
			text: 'bb',
			icon: 'code',
			menu: items
		});

	});
})();