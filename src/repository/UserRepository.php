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

    public function getUserByEmail(string $email) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // disconnect here
        return $user;
    }

    public function createUser(
        string $email,
        string $hashedPassword,
        string $firstname,
        string $lastname,
        string $bio = ''
    ) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, firstname, lastname, bio) 
            VALUES (:email, :password, :name, :surname, :bio)
        ');

        $stmt->execute([
            $email,
            $hashedPassword,
            $firstname,
            $lastname,
            $bio
        ]);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':name', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);

        $stmt->execute();
    }
}