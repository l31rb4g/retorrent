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
			'onSuccess': function(r){
				console.log(r);
			}
		});
		this.timer = setInterval(function(){
			this.request.send();
		}.bind(this), 2000);
	}
});