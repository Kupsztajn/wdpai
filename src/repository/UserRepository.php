<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users 
        ');
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        return $user;
    }

}