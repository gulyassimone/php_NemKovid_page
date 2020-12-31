<?php
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/storages/bookingstorage.php');

session_start();
$userStorage = new UserStorage();
$auth = new Auth($userStorage);
$bookingStorage = new BookingStorage();
$appointmentStorage = new AppointmentStorage();


$uri_parts = explode('?', $_SERVER['REQUEST_URI'], '2');

if ($auth->is_authenticated()) {
    $user = $auth->authenticated_user();
    $bookingsByUser = $bookingStorage->findOne(["user_id" => $user["id"]]);
}


if (isset($_GET['month'])) {
    $actualDate = $_GET['month'];
} else {
    $actualDate = strtotime(date('Y-m-d'));
}
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

<h1>Nemzeti Koronavírus Depó</h1>
<p>A Nemzeti Koronavírus Depó (NemKoViD - Mondj nemet a koronavírusra!) központi épületében különböző időpontokban
    oltásokat szervez. A honlapon koronavírus elleni oltásra lehet időpontot foglalni.</p>
</div>

<div class="bg-warning fw-bolder">
    <?php if (isset($bookingsByUser) && count($bookingsByUser) > 0) : ?>
        Meglévő foglalásod:<br>
        <?= date("Y-m-d H:i",$appointmentStorage->findById($bookingsByUser["appointment_id"])['time'])?>
    <?php endif; ?>
</div>

<h2> Időpontok: </h2>
<div class="container">
    <table class="table">
        <caption><?= date('F', $actualDate) ?></caption>
        <thead>
        <tr>
            <th scope="col">Dátum</th>
            <th scope="col">Időpont</th>
            <th scope="col">Szabad Helyek</th>
            <th scope="col">Jelentkezés</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($appointmentStorage->findAllActualMonth(date('m', $actualDate)) as $appointment) : ?>
        <?php $bookingsByApp = $bookingStorage->findAll(["appointment_id" => $appointment["id"]]); ?>
        <tr class="<?= count($bookingsByApp) < (int)$appointment['free'] ? "table-success" : "table-danger" ?>">
            <td><?= date("Y.m.d", $appointment['time']) ?></td>
            <td><?= date("H:i", $appointment['time']) ?></td>
            <td><?= count($bookingsByApp) ?>\<?= $appointment['free'] ?> szabad hely</td>

            <td>
                <?php if (count($bookingsByApp) < (int)$appointment['free'] && (!$auth->is_authenticated() || empty($bookingsByUser))) : ?>
                    <a id="apply" class="btn btn-info"
                       href="book_an_appointment.php?appointment_id=<?= $appointment['id'] ?>">Jelentkezés</a>
                <?php elseif ($auth->is_authenticated() && $bookingsByUser['appointment_id'] === $appointment['id']) : ?>
                    <a id="apply" class="btn btn-info"
                       href="cancel_appointment.php?appointment_id=<?= $appointment['id'] ?>">Lemondás</a>
                <?php endif; ?>
            </td>
</div>
    </tr>
<?php endforeach ?>
</tbody>
</table>
<div>
    <a class="btn btn-dark" href="<?= $uri_parts[0] ?>?month=<?= strtotime('-1 months', $actualDate) ?>">Előző hónap</a>
    <a class="btn btn-dark" href="<?= $uri_parts[0] ?>?month=<?= strtotime('+1 months', $actualDate) ?>">Következő
        hónap</a>
</div>
</div>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>
