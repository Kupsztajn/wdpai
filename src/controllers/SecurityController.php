<?php

require_once 'AppController.php';

class SecurityController extends AppController {


        // ======= LOKALNA "BAZA" UŻYTKOWNIKÓW =======


    public function login()
    {
        
        
        if (!$this->isPost()) {
            return $this->render('login');
        }

        var_dump($_POST);

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if($email === ''){
            return $this->render('login', ['message' => 'Email cannot be empty']);
        }

        if (empty($email) || empty($password)) {
            return $this->render('login', ['message' => 'Fill all fields']);
        }

       //TODO replace with search from database
        $userRow = null;
        foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                $userRow = $u;
                break;
            }
        }

        if (!$userRow) {
            return $this->render('login', ['message' => 'User not found']);
        }

        if ($password !== $userRow['password']) {
            return $this->render('login', ['message' => 'Wrong password']);
        }
        // TODO możemy przechowywać sesje użytkowika lub token
        // setcookie("username", $userRow['email'], time() + 3600, '/');

        $url = "http://$_SERVER[HTTP_HOST]";
        //header("Location: {$url}/dashboard");

        // TODO pobieramy z formularza email, haslo
        // todo sprawdzamy czy taki user istnieje w db
        // jezeli nie istnieje to zwracamy odpowiednie komunikaty
        // jezeli istnieje to logujemy usera (tworzymy sesje)
        return $this->render('dashboard');
    }

    public function logout()
    {
        // Logic for logging out the user
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function register()
    {
        // Logic for registering a new user
        if (!$this->isPost()) {
            return $this->render('register');
        }

        var_dump($_POST);
        

        // TODO pobieramy z formularza email, haslo, imie itp.
        // todo sprawdzamy czy taki user juz nie istnieje w db
        // jezeli istnieje to zwracamy odpowiednie komunikaty
        // jezeli nie istnieje to tworzymy nowego usera w db
        // logujemy usera (tworzymy sesje)
        return $this->render('login');
    }

}