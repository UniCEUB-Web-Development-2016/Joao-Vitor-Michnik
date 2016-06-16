<?php

class Participants
{
    private $cod_party;
    private $cod_user;

    public function __construct($party, $user)
    {
        $this->setParty($party);
        $this->setUser($user);
    }

    public function getParty()
    {
        return $this->cod_party;
    }
    public function setParty($party)
    {
        $this->cod_party = $party;
    }
    public function setUser($user)
    {
        $this->cod_user = $user;
    }
    public function getUser()
    {
        return $this->cod_user;
    }


}