<?php
require_once(__DIR__ .'/../Model/User.php');

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function showUser($username) {
        $user = $this->userModel->getUserByUsername($username);
        require 'view/user_view.php';
    }
}
