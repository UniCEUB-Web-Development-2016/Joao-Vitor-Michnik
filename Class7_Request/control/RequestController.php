<?php

class RequestController
{

	public function executeRequest($request)
	{
		$uri = $request->get_uri();
		
	}


	public function getResource($uri)
	{
	     $exp_bar = explode('/', $uri);
	     $rpl_bar = str_replace("/", "", $exp_bar[3]);
		 $exp_ask = explode('?', $rpl_bar);
		 return $exp_ask[0];
	}

	
	public function getParameters($uri)
	{
		$exp_ask = explode('?', $uri);
		$rplc_array = str_replace(array("=","&"),",", $exp_ask[1]);
		$exp_comma = explode(',', $rplc_array);
		for ($i = 0; $i < count($exp_comma); $i += 2)
			$ass_array[ $exp_comma[$i] ] = $exp_comma[$i+1];

		return json_encode($ass_array);

	}









}