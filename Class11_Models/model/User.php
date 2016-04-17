<?php

/**
 * Created by PhpStorm.
 * User: jock_
 * Date: 16/04/2016
 * Time: 18:27
 */
class User
{
    private $id;
    private $first_name;
    private $last_name;
    private $birthday;
    private $email;
    private $login;
    private $relationship_status;
    private $hometown;
    private $profile_photo;


    public function __construct($first_name, $last_name, $birthday, $email, $login, $relationship_status, $hometown, $profile_photo)
    {
        $this->set_first_name($first_name);
        $this->set_last_name($last_name);
        $this->set_birthday($birthday);
        $this->set_email($email);
        $this->set_login($login);
        $this->set_relationship_status($relationship_status);
        $this->set_hometown($hometown);
        $this->set_profile_photo($profile_photo);
    }
    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getRelationshipStatus()
    {
        return $this->relationship_status;
    }

    public function setRelationshipStatus($relationship_status)
    {
        $this->relationship_status = $relationship_status;
    }

    public function getHometown()
    {
        return $this->hometown;
    }

    public function setHometown($hometown)
    {
        $this->hometown = $hometown;
    }

    public function getProfilePhoto()
    {
        return $this->profile_photo;
    }

    public function setProfilePhoto($profile_photo)
    {
        $this->profile_photo = $profile_photo;
    }

    public function getId()
    {
        return $this->id;
    }

}