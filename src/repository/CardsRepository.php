<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Card.php';

class CardsRepository extends Repository{

    public function getCardsByTitle(string $searchString) {

        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM cards
            WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($cards as $card) {
            $result[] = new Card(
                $card['title'],
                $card['description'],
                $card['image'],
                $card['id']
            );
        }

        return $result;
    }
}