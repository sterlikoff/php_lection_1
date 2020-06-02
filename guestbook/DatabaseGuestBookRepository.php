<?php

include_once "DatabaseRepository.php";

class DatabaseGuestBookRepository
{

    use DatabaseRepository;

    const limit = 5;
    const messages_table_name = "messages";

    /**
     * @param GuestbookMessage $message
     * @return bool
     * @throws Exception
     */
    public function add($message)
    {

        $this->connect();

        $attributes = [
            $message->user->id,
            $message->message,
            $message->time,
        ];

        $attributes = array_map(function ($item) {
            return "\"$item\"";
        }, $attributes);

        $this->query("INSERT INTO " . self::messages_table_name . " (user_id, text, time) VALUES (" . implode(",", $attributes) . ")");
        return true;

    }

    /**
     * @param int $page
     *
     * @return GuestbookMessage[]
     *
     * @throws Exception
     */
    public function getAll($page)
    {

        $userRepository = new UserRepository();

        $offset = ($page - 1) * self::limit;

        $this->connect();
        $array = $this->query("SELECT * FROM " . self::messages_table_name . " ORDER BY id DESC LIMIT " . self::limit . " OFFSET $offset");

        $messages = [];
        foreach ($array as $item) {

            $message = new GuestbookMessage($userRepository->getById($item["user_id"]), $item["text"]);
            $message->time = $item["time"];

            $messages[] = $message;

        }

        return $messages;

    }

    /**
     * @param int|null $userId
     * @return mixed
     * @throws Exception
     */
    public function getMessagesCount($userId = null)
    {

        $varName = "message_count";
        $this->connect();

        $query = "SELECT COUNT(*) AS $varName FROM " . self::messages_table_name;
        if ($userId) $query .= " WHERE user_id = {$userId}";

        $data = $this->query($query);

        return $data[0][$varName];

    }

}