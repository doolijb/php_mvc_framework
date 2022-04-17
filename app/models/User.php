<?php

class User
{
    private $db;
    public function __construct () {
        $this->db = new Database;
    }
    public function getUsers() {
        $this->db->query("SELECT * FROM users");

        return $this->db->resultSet();
    }

    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');

        // Bind email param to query
        $this->db->bind(':email', $email);

        return $this->db->resultSet();
    }

    public function register($data) {
        /**
         * User model class function to save a user to the database.
         * @param: $data = array(
         *  'username' => String,
         *  'password' => String    // hashed
         * )
         * @return: Boolean - Whether the registration query was successful.
         */

        // Build the query
        $this->db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');

        // Bind query params
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute & return boolean
        return boolval($this->db->execute());
    }

    public function login($data) {
        /**
         * User model class function to auth a user.
         * @param: $data = array(
         *  'username' => String,
         *  'password' => String            // plain
         * )
         * @return: $user: User || false    // returns a user if auth, else false
         */

        // Build the query
        $this->db->query('SELECT * FROM users WHERE username = :username');

        // Bind query params
        $this->db->bind(':username', $data['username']);

        // Get qeuried user
        $user = $this->db->single();

        // If password is auth, return user
        if (password_verify($data['password'], $user->password)) {
            return $user;
        }

        // All else, return false
        return false;

    }
}