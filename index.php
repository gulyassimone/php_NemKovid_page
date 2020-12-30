<?php
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');


$appointment_storage = new AppointmentStorage();

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
    <div class="row align-items-start">
        <div class="col">
            <ul id=announced_dates>
                <?php foreach ($appointment_storage->findAllActualMonth((int)date('m', strtotime('-1 months'))) as $appointment) : ?>
                    <li class="<?= $appointment['users']==="" ? "text-success" : "text-danger" ?>"><?= date("Y.m.d H:i", $appointment['time']) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="col">
            <ul id=announced_dates>
                <?php foreach ($appointment_storage->findAllActualMonth((int)date('m')) as $appointment) : ?>
                    <li class="<?= $appointment['users']==="" ? "text-success" : "text-danger" ?>"><?= date("Y.m.d H:i", $appointment['time']) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="col">
            <ul id=announced_dates>
                <?php foreach ($appointment_storage->findAllActualMonth((int)date('m', strtotime('+1 months'))) as $appointment) : ?>
                    <li class="<?= $appointment['users']==="" ? "text-success" : "text-danger" ?>"><?= date("Y.m.d H:i", $appointment['time']) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
<script>
    incrementButton = document.querySelector("#incrementMonth");
    decrementButton = document.querySelector("#decrementMonth");
    incrementButton.addEventListener("click", function () {
    })
</script>
</body>
</html>
