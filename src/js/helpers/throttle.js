function throttle ( callback, timer, time ) {
	if ( timer ) {
		return;
	}
	timer = true;
	setTimeout( function() {
		callback();
		timer = false;
	}, time );
}

export { throttle };
