<?php

include_once "DatabaseRepository.php";

class UserRepository
{

    use DatabaseRepository;

    const users_table_name = "users";

    /**
     * @param User $model
     * @return bool
     * @throws Exception
     */
    public function add($model) {

        if (!$model->name || !$model->password) return false;

        $this->connect();

        if ($this->getByName($model->name)) return false;

        $attributes = [
            $model->name,
            $model->password,
            time(),
        ];

        $attributes = array_map(function ($item) {
            return "\"$item\"";
        }, $attributes);

        $this->query("INSERT INTO " . self::users_table_name . " (name, password, registration_time) VALUES (" . implode(",", $attributes) . ")");
        return true;

    }

    /**
     * @param $field
     * @param $value
     * @return false|User
     * @throws Exception
     */
    protected function getByField($field, $value) {

        $this->connect();
        $query = "SELECT * FROM " . self::users_table_name . " WHERE {$field} = '{$value}'";
        $data = $this->query($query);

        if (!count($data)) return false;

        $model = new User($data[0]["name"], $data[0]["password"]);
        $model->id = $data[0]["id"];
        $model->registration_time = $data[0]["registration_time"];

        return $model;

    }

    /**
     * @param string $name
     *
     * @return false|User
     *
     * @throws Exception
     */
    public function getByName($name) {
        return $this->getByField("name", $name);
    }

    /**
     * @param $id
     * @return false|User
     * @throws Exception
     */
    public function getById($id) {
        return $this->getByField("id", $id);
    }

    /**
     * @param $name
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function login($name, $password) {

        $user = $this->getByName($name);
        if (!$user) return false;

        if ($user->password !== $password) return false;

        $_SESSION["userId"] = $user->id;

        return true;
    }

    /**
     * @return false|User
     * @throws Exception
     */
    public function getCurrentUser() {

        if (!isset($_SESSION["userId"])) return false;
        if (!$userId = $_SESSION["userId"]) return false;
        return $this->getById($userId);

    }

    public function getUsersCount()
    {

        $varName = "users_count";
        $this->connect();

        $data = $this->query("SELECT COUNT(*) AS $varName FROM " . self::users_table_name);

        return $data[0][$varName];

    }

}