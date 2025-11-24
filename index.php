<?php
    //phpinfo();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./node_modules\bootstrap\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="./css/main.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./assets/icon/bfw-icon.svg" type="image/x-icon">
</head>
<body>
    <header>
        <div class="header-container container-fluid">
            <nav class="header align-middle">
                <img src="./assets/icon/bfw-icon.svg" alt="BFW Icon" class="navbar-brand-icon">
                <a class="navbar-brand align-middle" href=""><b>bfw</b>nürnberg</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="main-container">
            <h1 class="text-center"> Dashboard - BAT Man</h1>
            <div class="login-box text-center">
                <div class="login-title">
                    <h2>Login</h2>
                </div>
                <div class="mb-3">
                    <label for="vorname" class="form-label">Vorname:</label>
                    <input type="text" id="vorname" name="vorname" class="form-control">                    
                </div>
                <div class="mb-3">
                    <label for="nachname" class="form-label">Nachname:</label>
                    <input type="text" id="nachname" name="nachname" class="form-control">
                </div>
                <button type="button" id="GetToken" class="btn btn-primary show">Get Token</button>
                <div class="hidden">
                    <div class="d-flex align-items-center justify-content-center mt-3" id="loading">
                        <strong role="status">Loading...</strong>
                        <div class="spinner-border ms-auto" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container container-fluid">
            <div class="text-center">
                <p>© 2025 BAT Man - Projekt - Berufsförderungswerk Nürnberg GmbH</p>
            </div>
        </div>
    </footer>
    <script src="./node_modules\bootstrap\dist\js\bootstrap.bundle.min.js"></script>
    <script src="./js/main.js?v=<?php echo time(); ?>"></script>
</body>
</html>