<?php

class GuestbookMessage
{

    /** @var User */
    public $user;

    public $message;
    public $time;

    /**
     * GuestbookMessage constructor.
     *
     * @param User $user
     * @param string $message
     */
    public function __construct($user, $message)
    {

        $this->user = $user;
        $this->message = $message;
        $this->time = time();

    }

    private $errors = [];

    /**
     * @return bool
     */
    public function validate() {

        $hasErrors = false;
        $this->errors = [];

        if (!$this->user) {
            $hasErrors = true;
            $this->errors[] = "Не заполнено ваше имя";
        }

        if (!$this->message) {
            $hasErrors = true;
            $this->errors[] = "Не заполнено ваше сообщение";
        }

        return !$hasErrors;

    }

    /**
     * @return bool
     */
    public function hasErrors() {
        return count($this->errors) !== 0;
    }

    /**
     * @return string
     */
    public function errorSummary() {
        return implode(PHP_EOL, $this->errors);
    }

}