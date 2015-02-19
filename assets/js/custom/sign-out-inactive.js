	var timeOut;
	function reset() {
    window.clearTimeout(timeOut);
    timeOut = window.setTimeout( "redir()" , 900000 );
	}
	function redir() {
    window.location = "../../../sign-out-inactive.php";
	}

