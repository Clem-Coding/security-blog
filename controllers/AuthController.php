<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class AuthController extends AbstractController
{
    public function login(): void
    {
        if (!isset($_SESSION['csrf_token'])) {
            $csrfTokenManager = new CSRFTokenManager();
            $_SESSION['csrf_token'] = $csrfTokenManager->generateCSRFToken();
        }


        $this->render("login", ['csrf_token' => $_SESSION['csrf_token']]);
    }

    public function checkLogin(): void
    {
        // si le login est valide => connecter puis rediriger vers la home
        // $this->redirect("index.php");

        // sinon rediriger vers login
        // $this->redirect("index.php?route=login");
    }

    public function register(): void
    {
        $csrfManager = new CSRFTokenManager();
        $csrfToken = $csrfManager->generateCSRFToken();
        $_SESSION['csrf_token'] = $csrfToken;
        $this->render("register", ["csrf_token" => $csrfToken]);
    }

    public function checkRegister(): void
    {


        // Vérification du token CSRF
        if (!isset($_POST['csrf-token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf-token'])) {
            // Token CSRF invalide ou absent
            $this->redirect("index.php?route=register");
            return;
        }

        // Suppression du token CSRF de la session après vérification
        unset($_SESSION['csrf_token']);


        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $this->redirect("index.php?route=register");
            return;
        }

        if ($password !== $confirmPassword) {
            $this->redirect("index.php?route=register");
            return;
        }
        //d'autres verifs à prévoir, revoir expo passé sur le sujet

        //Si tout est ok, on insère le nouveau user dans la BDD
        $user = new User($username, $email, $password);
        $userManager = new UserManager();
        $userManager->create($user);


        $this->redirect('index.php');
    }

    public function logout(): void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}
