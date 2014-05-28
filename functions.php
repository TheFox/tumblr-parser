<?php

function ve($v = null){
	try{
		print '<pre>';
		var_export($v);
		print "</pre>\n";
	}
	catch(Exception $e){
		print "ERROR: ".$e->getMessage()."\n";
	}
}

function vej($v = null){
	try{
		ve(json_encode($v));
	}
	catch(Exception $e){
		print "ERROR: ".$e->getMessage()."\n";
	}
}
