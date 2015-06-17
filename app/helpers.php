<?php

function addWebOneStyle($data){

	// Adds border="0" to table tage
	$data = str_replace("<table>", "<table border=\"0\">", $data);

	// Tags every even tr with an even class and every odd tr with an odd class
	$i=0;
	$data = preg_replace_callback('/\<tr\>/',function($matches) use(&$i){		
		$val = '<tr class="'.($i%2==0?'even':'odd').'">';
		$i++;
		return $val;
	},
	$data);

	return $data;
}