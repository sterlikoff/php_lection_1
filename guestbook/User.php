<?php


class User
{

    public $id;
    public $name;
    public $password;
    public $registration_time;

    /**
     * User constructor.
     *
     * @param string $name
     * @param string $password
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }


}