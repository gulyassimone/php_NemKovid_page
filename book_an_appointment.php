<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');
session_start();
$userStorage = new UserStorage();
$appointment_storage = new AppointmentStorage();
$auth = new Auth($userStorage);
$appointment_id=$_GET['appointment_id'];

if (!$auth->is_authenticated()) {

    redirect('login.php?appointment_id='.$appointment_id);
}
$user = $auth->authenticated_user();
$time = date("Y-m-d H:i",$appointment_storage->findById($appointment_id)['time']);



?>

<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ . "/app/template/header.php");
    ?>
    <title>NemKoViD - Időpont Foglalás</title>
</head>
<body class="container-md">

<?php
include(__DIR__ . "/app/template/navbar.php");
?>
<div class="container">
    <form action="" method="get">
        <div class="row justify-content-start">
            <div class="inline-block">
                Időpont: <?= $time ?><br>
                Név: <?= $user['name'] ?><br>
                Lakcín: <?= $user['address'] ?><br>
                Taj: <?= $user['taj'] ?><br>
                <input type="checkbox" name="admit" id="admit" class="d-inline p-2">
                <label for="admit" class="text-primary" class="d-inline p-2">Elfogadja az általános szerződési
                    feltételeket?</label>

            </div>
        </div>
        <button type="submit" class="btn btn-primary"> Megerősít</button>
    </form>
</div>

<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>

