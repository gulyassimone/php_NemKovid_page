<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');

session_start();
$userStorage = new UserStorage();
$auth = new Auth($userStorage);
if($auth->is_authenticated()){
    $auth->logout();
}
redirect("index.php");