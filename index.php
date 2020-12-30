<?php
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');



$appointment_storage = new AppointmentStorage();
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);



if(isset($_GET['month'])){
    $actualDate = $_GET['month'];
}else{
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

<h2> Időpontok: </h2>
<div class="container">
    <table class="table">
        <caption><?= date('F', $actualDate) ?></caption>
        <thead>
        <tr>
            <th scope="col">Dátum</th>
            <th scope="col">Időpont</th>
            <th scope="col">Szabad Helyek</th>
            <th scope="col">jelentkezett felhasználók</th>
            <th scope="col">Jelentkezés</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($appointment_storage->findAllActualMonth(date('m', $actualDate)) as $appointment) : ?>
            <tr class="<?= count($appointment['users']) < (int)$appointment['free'] ? "table-success" : "table-danger" ?>">
                <td><?= date("Y.m.d", $appointment['time']) ?></td>
                <td><?= date("H:i", $appointment['time']) ?></td>
                <td><?= count($appointment['users']) ?>\<?= $appointment['free'] ?> szabad hely</td>
                <td> <?php foreach ($appointment['users'] as $user) : ?>
                    <?= $user ?>,
                    <?php endforeach ?>
                </td>
                <td><a id="apply" class="btn btn-info" href="book_an_appointment.php?appointment_id=<?=$appointment['id']?>">Jelentkezés</a></td>
                </div>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<div>
    <a class="btn btn-dark" href="<?=$uri_parts[0]?>?month=<?=strtotime('-1 months', $actualDate)?>">Előző hónap</a>
    <a class="btn btn-dark" href="<?=$uri_parts[0]?>?month=<?=strtotime('+1 months', $actualDate)?>">Következő hónap</a>
</div>
</div>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>
