<?php

include_once "model/Request.php";
include_once "control/UserController.php";
include_once "control/PartyController.php";
include_once "control/MapController.php";

class ResourceController
{

	private $controlMap = 
	[
		"party" => "PartyController",
		"user" => "UserController",
		"map" => "MapController",
	];

	public function createResource($request)
	{
		return (new $this->controlMap[strtolower($request->get_resource())]())->register($request);
	}
}