<?php
include(__DIR__ . '/app/storages/appointmentstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');

$appointment_storage = new AppointmentStorage();
$errors = [];
$data = [];
print_r($_GET);

if (count($_GET) > 0) {

    if (validate($_GET, $data,$errors)) {
        $data["users"] = "";
        $appointment_storage->add($data);
        redirect('new_appointment.php');
    }

    print_r($errors);
}

function validate($get, &$data,&$errors): bool
{
    if (!isset($get['time'])) {
        $errors['time'] = "A dátum nincs kitöltve";
    } else if (trim($get['time']) == "") {
        $errors['time'] = "Nincs megadva dátum";
    } else  {
        $data["time"] = strtotime($get['time']);

        if( !$data["time"]){
            $errors['time'] = "Nem megfelelő dátum formátum";
        }
    }

    return count($errors) === 0;
}

?>
<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ . "/app/template/header.php");
    ?>
    <title>Új email cím regisztrálása</title>
</head>
<body class="container-md">
<?php
include(__DIR__ . "/app/template/navbar.php");
?>

<form action="" method="get" novalidate>
    <div class="mb-3">
        <div class="col-auto">
            <label for="time" class="form-label">Név: </label><input type="datetime-local" id="time" name="time"
                                                                     class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Új dátum hozzáadása</button>
</form>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>
