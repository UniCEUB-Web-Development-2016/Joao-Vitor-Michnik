<?php

include_once "model/Request.php";
include_once "control/UserController.php";
include_once "control/PartyController.php";
include_once "control/MapController.php";
include "control/ValidatorController.php";

class ResourceController
{
	private $val;
	private $controlMap = 
	[
		"party" => "PartyController",
		"user" => "UserController",
		"map" => "MapController",
	];

	public function __construct()
	{
		$this->val = new ValidatorController();
	}

	public function createResource($request)
	{

		$valid = $this->val->postValidation($request->get_resource(), $request->get_params());
		if($valid)
		{
			return (new $this->controlMap[strtolower($request->get_resource())]())->register($request);
		}else
		{
			return "Error: 400, Bad Request";
		}
	}
	public function searchResource($request)
	{

		$valid = $this->val->getValidation($request->get_resource(), $request->get_params());

		if($valid)
		{
		return (new $this->controlMap[strtolower($request->get_resource())]())->search($request);
		}else
		{
			return "Error: 400, Bad Request";
		}
	}
	public function updateResource($request)
	{
		$valid = $this->val->updateValidation($request->get_resource(), $request->get_params());

		if($valid)
		{
		return (new $this->controlMap[strtolower($request->get_resource())]())->update($request);
		}else
		{
			return "Error: 400, Bad Request";
		}
	}
	public function deleteResource($request)
	{
		$valid = $this->val->deleteValidation($request->get_resource(), $request->get_params());

		if($valid)
		{
		return (new $this->controlMap[strtolower($request->get_resource())]())->delete($request);
		}else
		{
			return "Error: 400, Bad Request";
		}
	}
}