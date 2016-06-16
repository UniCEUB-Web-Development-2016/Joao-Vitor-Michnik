<?php

include "model/Validator.php";


class ValidatorController
{

    private $controlMap =
        [
            "party" => array(
                "POST" => array('party_name','description','max_participants','age_group','initial_date','final_date','price', 'creator', 'city', 'map_lat', 'map_long'),
                "GET" => array('cod','party_name','description','max_participants','age_group','initial_date','final_date','price', 'creator', 'city',1),
                "DELETE" => array('cod'),
                "UPDATE" => array('party_name','description','max_participants','age_group','initial_date','final_date','price', 'creator', 'city'),
            ),
            "user" => array(
                "POST" => array('first_name','last_name','birthday','email','login','pass','relationship_status', 'hometown','gender'),
                "GET" => array('cod','first_name','last_name','birthday','email','login','pass','relationship_status', 'hometown','gender','session_broke',1),
                "DELETE" => array('email'),
                "UPDATE" => array('first_name','last_name','birthday','relationship_status', 'hometown','gender')
            ),
            "map" => array(
                "POST" => array('map_long','map_lat'),
                "GET" => array('map_long','map_lat', 1),
                "DELETE" => array('cod'),
                "UPDATE" => array('party_name','map_long','map_lat')
            ),
            "participants" => array(
                "POST" => array('cod_party'),
                "GET" => array('cod_party','cod_user', 1),
                "DELETE" => array('cod_party'),
                "UPDATE" => array('cod_party','cod_user')
            ),
        ];

    public function postValidation($resource, $params)
    {
        $validator = new Validator($resource, $params);

        $necessary = $this->controlMap[$validator->getResource()]["POST"];
        $inverse_necessary = array_flip($necessary);

        $diff_array = array_diff_key($params,$inverse_necessary);

        foreach($necessary as $key)
        {
            $empty = isset($params[$key]);

            if(!$empty || !empty($diff_array))
                return false;
        }
        return true;
    }
    public function getValidation($resource, $params)
    {
        $validator = new Validator($resource, $params);

        $necessary = $this->controlMap[$validator->getResource()]["GET"];
        $inverse_necessary = array_flip($necessary);

        foreach($params as $key => $value)
        {
            $exist = array_key_exists($key,$inverse_necessary);
            if(!$exist)
                return false;
        }
        return true;
    }
    public function deleteValidation($resource, $params)
    {
        $validator = new Validator($resource, $params);

        $necessary = $this->controlMap[$validator->getResource()]["DELETE"];
        $inverse_necessary = array_flip($necessary);

        foreach($params as $key => $value)
        {
            $exist = array_key_exists($key,$inverse_necessary);
            if(!$exist)
                return false;
        }
        return true;
    }
    public function updateValidation($resource, $params)
    {
        $validator = new Validator($resource, $params);

        $necessary = $this->controlMap[$validator->getResource()]["UPDATE"];
        $inverse_necessary = array_flip($necessary);

        foreach($params as $key => $value)
        {
            $exist = array_key_exists($key,$inverse_necessary);
            if(!$exist)
                return false;
        }
        return true;
    }
}