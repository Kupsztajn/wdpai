<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController {


        // ======= LOKALNA "BAZA" UŻYTKOWNIKÓW =======

    private $userRepository;
    public function __construct(){
        $this->userRepository = new UserRepository();

    }

    public function login()
    {
        
        
        if (!$this->isPost()) {
            return $this->render('login');
        }

        var_dump($_POST);

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if($email === '' || $password === ''){
            return $this->render('login', ['message' => 'Email cannot be empty']);
        }

        if (empty($email) || empty($password)) {
            return $this->render('login', ['message' => 'Fill all fields']);
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmail($email);


        if (!$user) {
            return $this->render('login', ['message' => 'User not found']);
        }

        if (!password_verify($password, $user['password'])) {
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
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password1'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';

        if (empty($email) || empty($password) || empty($firstname)) {
            return $this->render('register', ['message' => 'Fill all the fields']);

        }

        if ($password !== $password2) {
            return $this->render('register', ['message' => 'Passwords should be the same']);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->createUser(
            $email,
            $hashedPassword,
            $firstname,
            $lastname
        );

         // TODO pobieramy z formularza email, haslo, imie itp.
        // todo sprawdzamy czy taki user juz nie istnieje w db
        // jezeli istnieje to zwracamy odpowiednie komunikaty
        // jezeli nie istnieje to tworzymy nowego usera w db
        // logujemy usera (tworzymy sesje)
        return $this->render('login');
    }

}