window.addEvent('domready', function(){
	window.refresher = new Refresher();
});

Refresher = new Class({
	data: {'ajax': 1},
	initialize: function(){
		this.request = new Request.JSON({
			'url': '/',
			'method': 'POST',
			'data': this.data,
			'onError': function(){
				console.log('error');
			},
			'onSuccess': function(r){
				this.rebuildTable(r);
				setTimeout(function(){
					this.request.send();
				}.bind(this), 2000);
			}.bind(this)
		});
		setTimeout(function(){
			this.request.send();
		}.bind(this), 2000);
	},
	rebuildTable: function(r){
		$$('#torrentTable tr.ttr').dispose();
		Object.each(r.torrents, function(l){
			var tr = new Element('tr', {
				'class': 'ttr'
			}).adopt(
				new Element('td', {
					'class': 'tiny',
					'with': 420
				}).adopt(
					new Element('img', {
						'src': '/images/' + l.image,
						'width': 16,
						'height': 16,
						'title': l.title + l.entry,
						'border': 0,
						'align': 'absmiddle'
					}),
					new Element('a', {
						'href': 'maketorrent.php?download=' + l.entry
					}).adopt(
						new Element('img', {
							'src': 'images/down.gif',
							'width': 9,
							'height': 9,
							'title': 'Download torrent file',
							'border': 0,
							'align': 'absmiddle'
						})
					),
					new Element('span', {
						'text': ' ' + l.displayname
					})
				),
				new Element('td', {'align': 'right'}).adopt(
					new Element('font', {
						'class': 'tiny',
						'html': l.size
					})
				),
				new Element('td', {'align': 'center'}).adopt(
					new Element('a', {
						'href': 'message?to_user=' + l.owner
					}).adopt(
						new Element('font', {
							'class': 'tiny',
							'text': l.owner
						})
					)
				),
				new Element('td', {
					'valign': 'bottom',
					'html': l.status
				}),
				new Element('td').adopt(
					new Element('div', {
						'class': 'tiny',
						'align': 'center',
						'html': l.esttime
					})
				),
				new Element('td').adopt(
					new Element('div', {
						'align': 'center',
						'class': 'tpanel'
					}).adopt(
						new Element('a', {
							'href': 'details?torrent=' + l.entry + '&als=false',
							'events': {
								'click': function(ev){
									ev.stop();
									StartTorrent('/startpop?torrent=' + l.entry);
								}
							}
						}).adopt(
							new Element('img', {
								'src': 'images/properties.png',
								'width': 18,
								'height': 13,
								'title': 'Torrent Details - User: ' + l.owner,
								'border': 0
							})
						)
					)
				)
			);

			var tp = tr.getElement('.tpanel');
			if (l.run){
				if (l.run == 'on'){
					new Element('a', {
						'href': '/?torrent=' + l.entry,
						'events': {
							'click': function(ev){
								ev.stop();
								new Request({
									'url': '/?torrent=' + l.entry
								}).send();
								this.setStyles({
									'opacity': 0.5,
									'cursor': 'default'
								});
							}
						}
					}).adopt(
						new Element('img', {
							'src': '/images/run_on.gif',
							'width': 16,
							'height': 16,
							'title': 'Start torrent',
							'border': 0
						})
					).inject(tp);
				} else {
					new Element('img', {
						'src': '/images/run_off.gif',
						'width': 16,
						'height': 16,
						'title': 'Stopping',
						'border': 0
					}).inject(tp);
				}
			} else if (l.seed){
				new Element('a', {
					'href': '/?torrent=' + l.entry,
					'events': {
						'click': function(ev){
							ev.stop();
							new Request({
								'url': '/?torrent=' + l.entry
							}).send();
							this.setStyles({
								'opacity': 0.5,
								'cursor': 'default'
							});
						}
					}
				}).adopt(
					new Element('img', {
						'src': '/images/seed_' + l.seed + '.gif',
						'width': 16,
						'height': 16,
						'title': 'Seed torrent',
						'border': 0
					})
				).inject(tp);
			} else {
				new Element('a', {
					'href': '/?alias_file=' + l.alias + '&kill=' + l.kill_id + '&kill_torrent=' + l.entry,
					'events': {
						'click': function(ev){
							ev.stop();
							new Request({
								'url': '/?alias_file=' + l.alias + '&kill=' + l.kill_id + '&kill_torrent=' + l.entry
							}).send();
							this.setStyles({
								'opacity': 0.5,
								'cursor': 'default'
							});
						}
					}
				}).adopt(
					new Element('img', {
						'src': '/images/kill.gif',
						'width': 16,
						'height': 16,
						'title': 'Stop torrent',
						'border': 0
					})
				).inject(tp);
			}

			if (l['delete'] && l['delete'] == 'on'){
				new Element('a', {
					'href': '/?alias_file=' + l.alias + '&delfile=' + l.entry,
					'events': {
						'click': function(ev){
							if (!ConfirmDelete(l.entry)){
								ev.stop();
							}
						}
					}
				}).adopt(
					new Element('img', {
						'src': '/images/delete_on.gif',
						'width': 16,
						'height': 16,
						'border': 0
					})
				).inject(tp);
			} else {
				new Element('img', {
					'src': '/images/delete_off.gif',
					'width': 16,
					'height': 16,
					'border': 0
				}).inject(tp);
			}

			tr.inject($$('#torrentTable .btr')[0], 'before');
		});

		Object.each(r.system, function(l, k){
			$('lbl_' + k).set('html', l);
		});
	}
});



















function ShowDetails(name_file){
  window.open (name_file,'_blank','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=430,height=225');
}
function StartTorrent(name_file){
	myWindow = window.open (name_file,'_blank','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=700,height=530');
}
function ConfirmDelete(file){
	return confirm(_ABOUTTODELETE + ": " + file);
}
