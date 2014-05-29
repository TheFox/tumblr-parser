<?php

function ve($v = null){
	if(PHP_SAPI == 'cli'){
		var_export($v);
		print "\n";
	}
	else{
		print '<pre>';
		var_export($v);
		print "</pre>\n";
	}
}

function vej($v = null){
	ve(json_encode($v));
}
