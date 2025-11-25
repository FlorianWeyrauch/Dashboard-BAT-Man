<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursübersicht</title>
    <link rel="icon" href="./assets/icon/bfw-icon.svg" type="image/x-icon">

    <!-- CSS-Dateien -->
    <link rel="stylesheet" href="./node_modules\bootstrap\dist\css\bootstrap.min.css?">
    <link rel="stylesheet" href="./css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/overview.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/standard.css?v=<?php echo time(); ?>">
    
    <!-- JavaScript-Dateien -->
     <script defer src="./js/test-daten.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/session.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/template.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/main.js?v=<?php echo time(); ?>"></script>
    <script defer src="./node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
</head>
<body onload="loadStudentOverview()">

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Dashboard</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings.svg" alt="Einstellungen">
    </header>


    <main id="student_overview">

    </main>

    <footer>
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>
</body>
</html>