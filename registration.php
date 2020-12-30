<?php
declare(strict_types=1);

include(__DIR__ .'/app/storages/userstorage.php');
include(__DIR__ .'/app/lib/auth.php');
include(__DIR__ .'/app/lib/helper.php');

$errors = [];
$data = [];

$user_storage = new UserStorage();
$auth = new Auth($user_storage);

if (count($_POST) > 0) {
    if (validate($_POST, $data, $errors)) {
        if ($auth->user_exists($data['email'])) {
            $errors['email'] = "Ez az email cím már regisztrálva van";
        } else {
            $auth->register($data);
            redirect('login.php');
        }
    }
}

function validate($post, &$data, &$errors): bool
{
    if (!isset($post['name'])) {
        $errors['name'] = "A név nincs kitöltve";
    } else if (trim($post['name']) == "") {
        $errors['name'] = "Nincs megadva név";
    } else {
        $data['name'] = $post['name'];
    }

    if (!isset($post['taj'])) {
        $errors['taj'] = "A TAJ szám nincs kitöltve";
    } else if (trim($post['taj']) == "") {
        $errors['taj'] = "Nincs megadva TAJ szám";
    } else if (!preg_match("/[1-9]{9}/m", $post['taj'])) {
        $errors['taj'] = "Nem megfelelő taj szám";
    } else {
        $data['taj'] = $post['taj'];
    }

    if (!isset($post['address'])) {
        $errors['address'] = "A cím nincs kitöltve";
    } else if (trim($post['address']) == "") {
        $errors['address'] = "Nincs megadva  cím";
    } else {
        $data['address'] = $post['address'];
    }

    if (!isset($post['email'])) {
        $errors['email'] = "Az email cím nincs kitöltve";
    } else if (trim($post['email']) == "") {
        $errors['email'] = "Nincs megadva email cím";
    } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Nem megfelelő emailcím";
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

    if (!isset($post['password_confirmation'])) {
        $errors['password_confirmation'] = "A jelszó újra nincs kitöltve";
    } else if (trim($post['password_confirmation']) == "") {
        $errors['password_confirmation'] = "Nincs megadva jelszó újra";
    } else if ($post['password_confirmation'] !== $data['password']) {
        $errors['password_confirmation'] = "Nem egyezik a megadott jelszóval";
    }

    return count($errors) === 0;
}

?>
<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ ."/app/template/header.php");
    ?>
    <title>Regisztráció</title>
</head>
<body class="container-md">
<?php
include(__DIR__ ."/app/template/navbar.php");
?>

<form action="" method="post" novalidate>
    <div class="mb-3">
        <div class="col-auto">
            <label for="name" class="form-label">Név: </label><input type="text" id="name" name="name"
                                                                     class="form-control"
                                                                     value="<?= $_POST['name'] ?? "" ?>">
            <?php if (isset($errors['name'])) : ?>
                <div class="text-danger"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="col-auto">
            <label for="taj" class="form-label"> TAJ szám: </label>
            <input type="number" id="taj" name="taj" class="form-control" value="<?= $_POST['taj'] ?? "" ?>">
            <?php if (isset($errors['taj'])) : ?>
                <div class="text-danger"><?= $errors['taj'] ?></div>
            <?php endif; ?>
        </div>
        <div class="col-auto">
            <label for="address" class="form-label"> Értesítési cím: </label><input type="text" id="address"
                                                                                    name="address"
                                                                                    class="form-control"
                                                                                    value="<?= $_POST['address'] ?? "" ?>">
            <?php if (isset($errors['address'])) : ?>
                <div class="text-danger"><?= $errors['address'] ?></div>
            <?php endif; ?>
        </div>
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
        <div class="col-auto">
            <label for="password_confirmation" class="form-label"> Jelszó újra: </label><input type="password"
                                                                                               id="password_confirmation"
                                                                                               name="password_confirmation"
                                                                                               class="form-control"
                                                                                               value="<?= $_POST['password_confirmation'] ?? "" ?>">
            <?php if (isset($errors['password_confirmation'])) : ?>
                <div class="text-danger"><?= $errors['password_confirmation'] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Regisztrálás</button>
</form>
<?php
include(__DIR__ ."/app/template/footer.php");
?>
</body>
</html>
