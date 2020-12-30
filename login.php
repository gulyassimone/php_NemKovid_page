<?php
?>
<!doctype html>
<html lang="hu">
<head>
    <?php
    include(__DIR__ ."/app/template/header.php");
    ?>
    <title>Belépés</title>
</head>
<body class="container-md">
<?php
include(__DIR__ ."/app/template/navbar.php");
?>

<form action="/index.php" novalidate>
    <div class="mb-3">
        <label for="email" class="form-label"> Email cím: </label><input type="email" id="email" name="email"
                                                                         class="form-control"
                                                                         aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label"> Jelszó: </label><input type="password" id="password" name="password"
                                                                         class="form-control">
    </div>
        <button type="submit" class="btn btn-primary"> Belépés</button>
</form>
<?php
include(__DIR__ ."/app/template/footer.php");
?>
</body>
</html>
