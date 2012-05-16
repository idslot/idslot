	$(document).ready(function() {
		$('[title]').qtip({
			content: {
				text: false
			},
			hide: { effect: {length:500}, delay: 500, when: {event: 'focusout'} },
			show: { effect: {length:300}, when: {event: 'focusin'} },
			position: {
				corner: {
					target: 'rightMiddle',
		      tooltip: 'rightMiddle'
				}
			},
			style: {
				width: 115,
		    padding: 0,
        background: 'transparent',
		    color: '#666',
				textAlign: 'left',
		    border: {
					width: 0,
					radius: 0,
		      color: '#ddd'
		    }
		  }
			});
	});