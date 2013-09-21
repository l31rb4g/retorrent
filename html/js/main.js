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
				this.rebuildTable(r);
			}.bind(this)
		});
		this.timer = setTimeout(function(){
			this.request.send();
		}.bind(this), 2000);
	},
	rebuildTable: function(r){
		var last = ($$('#torrentTable tbody > tr').length - 1);
		$$('#torrentTable tbody > tr').filter(function(f,n){
			return (n > 0 && n < last);
		}).dispose();
		Object.each(r, function(l){
			var tr = new Element('tr').adopt(
				new Element('td', {'text': l.name})
			);
			tr.inject($$('#torrentTable tbody')[0]);
		});
	}
});