<?php

trait DatabaseRepository
{

    private $connect;

    /**
     * @throws Exception
     */
    protected function connect()
    {

        $this->connect = mysqli_connect("localhost", "mysql", "mysql");

        if ($this->connect == false) {
            $error = mysqli_connect_error();
            throw new Exception("База данных недоступна. $error.");
        }

        mysqli_select_db($this->connect, "gb");

    }


    /**
     * @param string $query
     *
     * @return mixed
     *
     * @throws Exception
     */
    protected function query($query)
    {

        $result = mysqli_query($this->connect, $query);
        if ($result == false) {
            $error = mysqli_error($this->connect);
            throw new Exception("Некорректный запрос. $error.");
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}