
<div class="menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/index.php" title="Főoldal">Főoldal</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login.php" title="Belépés">Belépés</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/registration.php"
                                            title="Regisztráció">Regisztráció</a>
                    </li>
                    <?php if ($auth->is_authenticated()) : ?>
                        <?php if ($auth->authorize(["admin"])) : ?>
                            <li class="nav-item"><a class="nav-link" href="/new_appointment.php"
                                                    title="Új dátum felvitele">Új
                                    dátum felvitele</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item badge bg-danger"><a class="nav-link " href="/logout.php"
                                                title="Kijelentkezés">Kijelentkezés</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
