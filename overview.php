<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursübersicht</title>
    <link rel="icon" href="./assets/icon/bfw-icon.svg" type="image/x-icon">

    <!-- CSS-Dateien -->
    <link rel="stylesheet" href="./node_modules\bootstrap\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/overview.css">
    <link rel="stylesheet" href="./css/standard.css">
</head>
<body>

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Dashboard</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings.svg" alt="Einstellungen">
    </header>


    <main>
        <h2 class="main-headline">Willkommen Herr Lange</h2>
        <!-- js dynamische ausgabe -->
        <div class="course-selection d-flex-c">
            <select name="courses" id="courses">
                <option value="" disabled selected hidden>Kursjahr auswählen</option>
                <option value="kurs1">2025</option>
                <option value="kurs2">2024</option>
                <option value="kurs3">2023</option>
            </select>
            <button class="">Zurücksetzen</button>
        </div>

        <!-- Kursübersicht -->
        <div id="course_overview">
            <!-- Dynamisch generierte Kurskarten werden hier eingefügt -->
        </div>
    </main>

    <footer>
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>
    <script src="./js/template.js"></script>
    <script src="./js/main.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>