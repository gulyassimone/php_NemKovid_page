<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/storages/bookingstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');

session_start();
$userStorage = new UserStorage();
$auth = new Auth($userStorage);
?>
<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ . "/app/template/header.php");
    ?>
    <title>NemKoViD - Főoldal</title>
</head>
<body class="container-md">

<?php
include(__DIR__ . "/app/template/navbar.php");
?>
<p class="fw-bold text-success">
    A jelentkezés sikeresen megtörtént!
</p>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>
