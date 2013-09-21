window.addEvent('domready', function(){
	window.refresher = new Refresher();
});

Refresher = new Class({
	data: {},
	initialize: function(){
		this.request = new Request.JSON({
			'url': '/index.php?ajax',
			'method': 'POST',
			'data': this.data,
			'onError': function(){
				console.log('error');
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