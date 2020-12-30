<?php
include(__DIR__ . '/app/storages/userstorage.php');
include(__DIR__ . '/app/lib/auth.php');
include(__DIR__ . '/app/lib/helper.php');
include(__DIR__ . '/app/storages/appointmentstorage.php');

$appointment_storage = new AppointmentStorage();

function validate($post, &$data, &$errors)
{
    if (!isset($post['email'])) {
        $errors['email'] = "Az email cím nincs kitöltve";
    } else if (trim($post['email']) == "") {
        $errors['email'] = "Nincs megadva email cím";
    } else {
        $data['email'] = $post['email'];
    }

    if (!isset($post['password'])) {
        $errors['password'] = "A jelszó nincs kitöltve";
    } else if (trim($post['password']) == "") {
        $errors['password'] = "Nincs megadva jelszó";
    } else {
        $data['password'] = $post['password'];
    }
    return count($errors) === 0;
}

session_start();
$user_storage = new UserStorage();
$auth = new Auth($user_storage);

$data = [];
$errors = [];


if ($_POST) {
    if (validate($_POST, $data, $errors)) {
        $auth_user = $auth->authenticate($data['email'], $data['password']);
        print_r("auth_user ");
        print_r($auth_user);
        if (!$auth_user) {
            $errors['global'] = "Nem megfelelő felhasználónév vagy jelszó";
        } else {
            $auth->login($auth_user);
            if (isset($_GET['appointment_id'])) {
                redirect('book_an_appointment.php?appointment_id='.$_GET['appointment_id']);
            } else {
                redirect('index.php');
            }
        }
    }
}

?>
<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ . "/app/template/header.php");
    ?>
    <title>Belépés</title>
</head>
<body class="container-md">
<?php
include(__DIR__ . "/app/template/navbar.php");
?>
<?php if (isset($errors['global'])) : ?>
    <div class="text-danger"><?= $errors['global'] ?></div>
<?php endif; ?>

<form action="" method="post" novalidate>
    <div class="mb-3">
        <div class="col-auto">
            <label for="email" class="form-label"> Email cím: </label><input type="email" id="email" name="email"
                                                                             class="form-control"
                                                                             aria-describedby="emailHelp"
                                                                             value="<?= $_POST['email'] ?? "" ?>">
            <?php if (isset($errors['email'])) : ?>
                <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>
        <div class="col-auto">
            <label for="password" class="form-label"> Jelszó: </label><input type="password" id="password"
                                                                             name="password"
                                                                             class="form-control"
                                                                             value="<?= $_POST['password'] ?? "" ?>">
            <?php if (isset($errors['password'])) : ?>
                <div class="text-danger"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Belépés</button>
</form>
<?php
include(__DIR__ . "/app/template/footer.php");
?>
</body>
</html>
