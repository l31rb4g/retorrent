window.addEvent('domready', function(){
	window.refresher = new Refresher();
});

Refresher = new Class({
	initialize: function(){
		this.request = new Request.JSON({
			'url': '/index.php',
			'method': 'POST',
			'data': {
				'ajax': '1'
			},
			'onSuccess': function(ev){

			}
		});
	}
});