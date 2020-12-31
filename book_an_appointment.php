<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/storages/bookingstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');

session_start();
$userStorage = new UserStorage();
$auth = new Auth($userStorage);

$appointment_storage = new AppointmentStorage();
$bookingStorage = new BookingStorage();

$appointment_id = $_GET['appointment_id'];

$errors = [];
$data = [];

if (!$auth->is_authenticated()) {

    redirect('login.php?appointment_id=' . $appointment_id);
}
$user = $auth->authenticated_user();
$appointment = $appointment_storage->findById($appointment_id);


function validate($get, $bookingStorage, $user, $appointment_id, $appointment,&$errors)
{
    $actualUserBooking = $bookingStorage->findOne(["user_id" => $user["id"]]) ?? [];
    $actualAppBooking = $bookingStorage->findAll(["appointment_id" => $appointment_id]) ?? [];



    if (!isset($get['admit'])) {
        $errors['admit'] = "Az általános szerződési feltételek nincs elfogadva.";
    }
    if (count($actualUserBooking)>0) {
        $errors["booking"]="Már van foglalásod!";
    }
    if ($appointment["free"] <= count($actualAppBooking) ) {
        $errors["global"]="Beteltek a helyek.";
    }

    return count($errors) === 0;
}

if (validate($_GET, $bookingStorage, $user, $appointment_id,$appointment, $errors)) {
    print_r($errors);
    $data['appointment_id'] = $appointment_id;
    $data['user_id'] = $user['id'];


    $bookingStorage->add($data);
    redirect("success_booking.php");
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
    <?php if(count($errors)>0) : ?>
    <ul class="text-danger">
    <?php foreach ($errors as $error) :?>
        <li><?=$error ?></li>
    <?php endforeach; ?>
        </ul>
    <?php endif;?>
    <form action="" method="get" novalidate>
        <div class="row justify-content-start">
            <div class="inline-block">
                Időpont: <?= date("Y-m-d H:i", $appointment['time']) ?><br>
                <input name="appointment_id" value="<?= $appointment_id ?>" hidden>
                Név: <?= $user['name'] ?><br>
                Lakcín: <?= $user['address'] ?><br>
                Taj: <?= $user['taj'] ?><br>
                <input type="checkbox" name="admit" id="admit" value="false" class="d-inline p-2">
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

