<?php

class Posts extends Controller
{
    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    public function index() {

        $data = [
            'title' => 'All posts',
            'posts' => $this->postModel->findAllPosts()
        ];

        $this->view('posts/index', $data);
    }

    public function create() {

        // Permissions
        if(!isLoggedIn()) {
            header('Location: ' . URLROOT . '/posts');
        } else {

            // Default data
            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => '',
                'body' => '',
                'titleError' => '',
                'bodyError' => '',
            ];

            // POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Sanitize and get data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Validate and get title
                if(empty(trim($_POST['title']))) {
                    $data['titleError'] = 'Please enter a title.';
                } else {
                    $data['title'] = trim($_POST['title']);
                }

                // Validate body
                if(empty(trim($_POST['body']))) {
                    $data['bodyError'] = 'Please enter a post body.';
                } else {
                    $data['body'] = trim($_POST['body']);
                }

                // If no errors, save the post and redirect to posts
                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->addPost($data)) {
                        header('Location: ' . URLROOT . '/posts');
                    } else {
                        die("Something went wrong, please try again!");
                    }
                }
                // Else return with errors
                else {
                    $this->view('posts/create', $data);
                }
            }
            // GET (default)
            else {
                $this->view('posts/create', $data);
            }

        }
    }

    public function update($id) {

        // Permissions
        if(!isLoggedIn()) {
            header('Location: ' . URLROOT . '/posts');
        } else {

            // Get post
            $post = $this->postModel->findPostById($id);

            // Die if no post is found
            if(!$post) {
                die('Post not found');
            }
            // Die if user is not author
            if($post->user_id !== $_SESSION['user_id']) {
                die('You do not have permission to update this post');
            }

            // Default data
            $data = [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'user_id' => $_SESSION['user_id'],
                'titleError' => '',
                'bodyError' => '',
            ];

            // POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Sanitize and get data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Validate and get title
                if(empty(trim($_POST['title']))) {
                    $data['titleError'] = 'Please enter a title.';
                } else {
                    $data['title'] = trim($_POST['title']);
                }

                // Validate body
                if(empty(trim($_POST['body']))) {
                    $data['bodyError'] = 'Please enter a post body.';
                } else {
                    $data['body'] = trim($_POST['body']);
                }

                // If no errors, save the post and redirect to posts
                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->updatePost($data)) {
                        header('Location: ' . URLROOT . '/posts');
                    } else {
                        die("Something went wrong, please try again!");
                    }
                }
                // Else return with errors
                else {
                    $this->view('posts/update', $data);
                }
            }
            // GET (default)
            else {
                $this->view('posts/update', $data);
            }

        }
    }

    public function delete($id) {

        // Permissions
        if(!isLoggedIn()) {
            header('Location: ' . URLROOT . '/posts');
        } else {

            // Get post
            $post = $this->postModel->findPostById($id);

            // Die if no post is found
            if(!$post) {
                die('Post not found');
            }
            // Die if user is not author
            if($post->user_id !== $_SESSION['user_id']) {
                die('You do not have permission to update this post');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data = [
                    'id' => $id
                ];

                // Delete the post and redirect to posts
                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->deletePost($data)) {
                        header('Location: ' . URLROOT . '/posts');
                    } else {
                        die("Something went wrong, please try again!");
                    }
                }

            } else {
                die('Method not allowed');
            }

        }
    }
}