<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/storages/bookingstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');

session_start();
$userStorage = new UserStorage();
$appointment_storage = new AppointmentStorage();
$auth = new Auth($userStorage);
$bookingStorage = new BookingStorage();

$appointment_id=$_GET['appointment_id'];

$errors = [];
$data = [];

if (!$auth->is_authenticated()) {

    redirect('login.php?appointment_id='.$appointment_id);
}
$user = $auth->authenticated_user();
$appointment = $appointment_storage->findById($appointment_id);


function validate($get, &$errors)
{
    if (!isset($get['admit']) ) {
        $errors['admit'] = "Az általános szerződési feltételek nincs elfogadva";
    }

    return count($errors) ===0;
}

if(validate($_GET,  $errors)){
    $data['appointment_id'] = $appointment_id;
    $data['user_id'] = $user['id'];

    $bookingStorage->add($data);

    redirect(index.php);
}
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
    <form action="" method="get" novalidate>
        <div class="row justify-content-start">
            <div class="inline-block" >
                Időpont: <?= date("Y-m-d H:i",$appointment['time']) ?><br>
                    <input name="appointment_id" value="<?=$appointment_id?>" hidden>
                Név: <?= $user['name'] ?><br>
                Lakcín: <?= $user['address'] ?><br>
                Taj: <?= $user['taj'] ?><br>
                <input type="checkbox" name="admit" id="admit" value="false"  class="d-inline p-2">
                <label for="admit" class="text-primary" class="d-inline p-2">Elfogadja az általános szerződési
                    feltételeket?</label>
                <?php if (isset($errors['admit'])) : ?>
                    <div class="text-danger"><?= $errors['admit'] ?></div>
                <?php endif; ?>

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

