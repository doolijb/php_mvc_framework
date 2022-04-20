<?php

class Post
{
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findAllPosts() {
        $this->db->query('SELECT * FROM posts ORDER BY created_at ASC');
        return $this->db->resultSet();
    }

    public function addPost($data) {
        $this->db->query('INSERT INTO posts (user_id, title, body) values (:user_id, :title, :body)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

    public function findPostById($id) {
        $this->db->query('SELECT * FROM posts WHERE id = :id');

        $this->db->bind(':id',  $id);

        return $this->db->single();
    }

    public function updatePost($data) {
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

    public function deletePost($data) {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $data['id']);

        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

}