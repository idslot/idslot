	$(document).ready(function() {
		$('[title]').qtip({
			content: {
				text: false
			},
			hide: { effect: {length:500}, delay: 500, when: {event: 'focusout'} },
			show: { effect: {length:300}, when: {event: 'focusin'} },
			position: {
				corner: {
					target: 'leftMiddle',
		      tooltip: 'leftMiddle'
				}
			},
			style: {
				width: 200,
		    padding: 0,
        background: 'transparent',
		    color: '#666',
				textAlign: 'right',
		    border: {
					width: 0,
					radius: 0,
		      color: '#ddd'
		    }
		  }
			});
	});