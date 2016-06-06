<?php

class Party
{
    private $id;
    private $name;
    private $description;
    private $max_participants;
    private $age_group;
    private $initial_date;
    private $final_date;
    private $price;
    private $creator;
    private $city;


    public function __construct($name, $description, $max_participants, $age_group, $initial_date, $final_date, $price, $creator, $city)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setMaxParticipants($max_participants);
        $this->setAgeGroup($age_group);
        $this->setInitialDate($initial_date);
        $this->setFinalDate($final_date);
        $this->setPrice($price);
        $this->setCreator($creator);
        $this->setCity($city);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getMaxParticipants()
    {
        return $this->max_participants;
    }
    public function setMaxParticipants($max_participants)
    {
        $this->max_participants = $max_participants;
    }
    public function getAgeGroup()
    {
        return $this->age_group;
    }
    public function setAgeGroup($age_group)
    {
        $this->age_group = $age_group;
    }
    public function getInitialDate()
    {
        return $this->initial_date;
    }

    public function setInitialDate($initial_date)
    {
        $this->initial_date = $initial_date;
    }

    public function getFinalDate()
    {
        return $this->final_date;
    }

    public function setFinalDate($final_date)
    {
        $this->final_date = $final_date;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator($creator)
    {
        $this->creator = $creator;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }


}