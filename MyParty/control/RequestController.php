<?php

include_once "model/Request.php";

class RequestController
{

	public function createRequest($protocol, $method, $uri, $server_addr)
	{

		$uri_separated = parse_url($uri);
		parse_str($uri_separated['query'], $params);

		return new Request(
			    $protocol,
				$method,
				$this->getResource($uri_separated['path']),
				$params,
				$server_addr);
	}	


	public function getResource($resource)
	{
		$resource_array = explode("/", $resource);
		return $resource_array[2];
	}






}