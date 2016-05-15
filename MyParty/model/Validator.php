<?php

class Validator
{
    private $class;
    private $params_compare;

    public function __construct($class, $parameters)
    {
        $this->setResource($class);
        $this->setParamsCompare($parameters);
    }

    public function getParameters()
    {
        return $this->params_compare;
    }

    public function setParamsCompare($params)
    {
        $this->params_compare = $params;
    }


    public function getResource()
    {
        return $this->class;
    }

    public function setResource($class)
    {
        $this->class = $class;
    }
}