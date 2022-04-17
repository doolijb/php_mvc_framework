<?php

class Users extends Controller {
    public function __construct() {
        $this->userModel = $this->model('User');
    }
    public function login() {
        /**
         * Rendering view that displays a user login page.
         * @method GET  // Renders an empty login form
         * @method POST // Validates POST data and authorizes a user with a session & redirects to home page, else renders login form with errors.
         */

        $data = [
            'title' => 'Login page',
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];

        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'usernameError' => '',
                'passwordError' => ''
            ];

            // Validate username
            if (empty($data['username'])) {
                $data['usernameError'] = 'Please enter a username.';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter a password.';
            }

            // Check if all errors are empty
            if (empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data);

                // If authed user
                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Password or username is incorrect, please try again';
                }
            }
        }

        $this->view('users/login', $data);
    }

    public function register() {
        /**
         * Rendering view that displays a user registration page.
         * @method GET  // Renders an empty registration form
         * @method POST // Validates POST data and register user & redirects to login page, else renders registration page with errors
         */
        $data = [
            'title' => 'Register page',
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];

        // POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Get POST data
            $data = [
                'title' => 'Register page',
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'confirmPassword' => $_POST['confirmPassword'],
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            // Regex validators
            $usernameValidation = "/^[a-zA-z0-9]*$/";
            $passwordValidation = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            // VALIDATE USERNAME
            // If username is empty
            if (empty($data['username'])) {
                $data['usernameError'] = 'Please enter username.';
            }
            // If username has invalid characters
            elseif (!preg_match($usernameValidation, $data['username'])) {
                $data['usernameError'] = 'Username may only contain letters and numbers';
            }

            // VALIDATE EMAIL
            // If email is empty
            if (empty($data['email'])) {
                $data['emailError'] = 'Please enter email address.';
            }
            // If email format is valid
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = 'Please enter a valid email address.';
            }
            // If email is taken
            elseif (count($this->userModel->findUserByEmail($data['email'])) > 0) {
                    $data['emailError'] = 'Email is already taken.';
            }

            // VALIDATE PASSWORD
            // If password is empty
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter password.';
            }
            // If password is too short
            elseif (strlen($data['password']) < 6) {
                $data['passwordError'] = 'Password must have at least 6 characters.';
            }
            // If password has no numbers or letters
            elseif (!preg_match($passwordValidation, $data['password'])) {
                $data['passwordError'] = 'Password must have at least one letter and one number and no special characters.';
            }
            elseif ($data['password'] != $data['confirmPassword']) {
                $data['confirmPasswordError'] = 'Passwords do not match, please try again.';
            }

            // Make sure that errors are empty
            if (
                empty($data['usernameError']) && empty($data['emailError'])
                && empty($data['passwordError']) && empty($data['confirmPasswordError'])
                ) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)) {
                    // Redirect to the login page
                    header('location: ' . URLROOT . '/users/login');
                } else {
                    die('Something went wrong.');
                }
            }

            $data['passwordTest'] = preg_match($passwordValidation, $data['password']);
        }

        $this->view('users/register', $data);
    }

    public function createUserSession($user) {
        /**
         * View helper that generates a user session and redirects to the home page
         * @param $user User    // User that has been auth
         */
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        header('location:' . URLROOT . '/pages/index');
    }

    public function logout() {
        /**
         * Non rendering view that deletes the user's session and redirects to login page
         */
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header('location:' . URLROOT . '/users/login');
    }

}