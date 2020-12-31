<?php
include(__DIR__ . '/../storages/appointmentstorage.php');
include(__DIR__ . '/../lib/auth.php');
include(__DIR__ . '/../lib/helper.php');
include(__DIR__ . '/../storages/userstorage.php');
include(__DIR__ . '/../storages/bookingstorage.php');

session_start();
$userStorage = new UserStorage();
$auth = new Auth($userStorage);
$bookingStorage = new BookingStorage();
$appointmentStorage = new AppointmentStorage();


if ($auth->is_authenticated()) {
    $user = $auth->authenticated_user();
    $bookingsByUser = $bookingStorage->findOne(["user_id" => $user["id"]]);
}


if (isset($_GET['month'])) {
    $actualDate = $_GET['month'];
} else {
    $actualDate = strtotime(date('Y-m-d'));
}
echo Date("Y-m-d", $actualDate);
?>

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
        <?php $bookingsByApp = $bookingStorage->findAll(["appointment_id" => $appointment["id"]]);
        $actualDate = $appointment['time']?>
        <tr class="<?= count($bookingsByApp) < (int)$appointment['free'] ? "table-success" : "table-danger" ?>">
            <td><?= date("Y.m.d", $appointment['time']) ?></td>
            <td><?= date("H:i", $appointment['time']) ?></td>
            <td><?= count($bookingsByApp) ?>\<?= $appointment['free'] ?> szabad hely</td>

            <td>
                <?php if ($auth->authorize(["admin"]) || count($bookingsByApp) < (int)$appointment['free'] && (!$auth->is_authenticated() || empty($bookingsByUser))) : ?>
                    <a id="apply" class="btn btn-info"
                       href="book_an_appointment.php?appointment_id=<?= $appointment['id'] ?>">Jelentkezés</a>
                <?php elseif ($auth->is_authenticated() && $bookingsByUser['appointment_id'] === $appointment['id']) : ?>
                    <a id="apply" class="btn btn-info"
                       href="cancel_appointment.php?appointment_id=<?= $appointment['id'] ?>">Lemondás</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<div>
    <a class="btn btn-dark" id="decrementButton" value="<?= strtotime('-1 months', $actualDate) ?>">Előző hónap</a>
    <a class="btn btn-dark" id="incrementButton" value="<?= strtotime('+1 months', $actualDate) ?>">Következő
        hónap</a>
</div>
