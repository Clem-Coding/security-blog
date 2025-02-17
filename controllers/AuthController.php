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

        //VERIF du CSRF

        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Token CSRF invalide ou manquant.';
            $this->redirect('index.php?route=login');
            return;
        }

        // Suppression du token CSRF de la session après vérification
        unset($_SESSION['csrf_token']);



        if (isset($_POST["email"], $_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $userManager = new UserManager();
            $user = $userManager->findByEmail($email);

            if ($user !== null) {
                $passwordIsValid = password_verify($password, $user->getPassword());
                if ($passwordIsValid) {
                    $_SESSION["user"] = ["username" => $user->getUsername()];
                    $this->redirect("index.php");
                    return;
                }
            }

            $_SESSION['error_message'] = 'Cet identifiant ou mot de passe est invalide, réessayez ou cliquez sur "mot de passe oublié';
            $this->redirect("index.php?route=login");
        }
    }


    public function register(): void
    {

        if (!isset($_SESSION['csrf_token'])) {
            $csrfTokenManager = new CSRFTokenManager();
            $_SESSION['csrf_token'] = $csrfTokenManager->generateCSRFToken();
        }

        $this->render("register", ['csrf_token' => $_SESSION['csrf_token']]);
    }

    public function checkRegister(): void
    {

        // Vérifier la présence du token CSRF dans la requête
        if (!isset($_SESSION['csrf_token'])) {
            // Token CSRF manquant
            $_SESSION['error_message'] = 'Token CSRF manquant.';
            $this->redirect("index.php?route=register");
            return;
        }



        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        $hash = password_hash($password, PASSWORD_BCRYPT); // chiffré avec l'algorithme BCRYPT
        $safeUsername = htmlspecialchars($username);
        $safeEmail = htmlspecialchars($email);

        //LES VERIFICATIONS

        //Les champs sont-ils remplis?
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $this->redirect("index.php?route=register");
            return;
        }

        // Est-ce que le mot de passe est assez fort?
        $passwordPattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#?!@$%^&*-]).{8,}$/";

        if (!preg_match($passwordPattern, $password)) {
            $_SESSION['error_message'] = "Le mot de passe doit contenir au moins 8 caractères, incluant une lettre majuscule, 
            une lettre minuscule, un chiffre et un caractère spécial.";
            $this->redirect("index.php?route=register");
            return;
        }

        if ($password !== $confirmPassword) {
            $this->redirect("index.php?route=register");
            return;
        }

        // Est-ce que l'utilisateur existe?
        $userManager = new UserManager();
        if ($userManager->userExists($username, $email)) {
            $_SESSION['error_message'] = "Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.";
            $this->redirect("index.php?route=register");
            return;
        }


        //Si tout est ok, on insère le nouveau user dans la BDD
        $user = new User($safeUsername, $safeEmail, $hash);
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
