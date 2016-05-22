<?php
function set_active($uri, $output = 'active')
{
	if( is_array($uri) ) {
	    foreach ($uri as $u) {
	    	if (Request::is($u)) {
	       		return $output;
	    	}
		}
	} else {
	   	if (Request::is($uri)){
	     	return $output;
	  	}
	}
}

function flash($title = null, $message = null)
{
	$flash = app('App\Http\Flash');

	if(func_num_args() == 0) {
		return $flash;
	}

	return $flash->message($title, $message);	
}
?>