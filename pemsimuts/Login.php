<?php
class Login
{
    function index()
    {
        if (isset($_POST['signin'])) {
            $_SESSION['user'] = htmlspecialchars($_POST['user']);
            header('Location: ' . root . 'Index.php');
        } else {
            require_once 'login_view.php';
        }
    }
}
