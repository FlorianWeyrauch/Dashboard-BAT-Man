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
    <link rel="stylesheet" href="./css/standard.css">
    <style>
        .bfw-icon {
            height: 80px;
            width: auto;
        }

        .settings-icon {
            height: 50px;
            width: auto;
        }

        .course-selection {
            gap: 24px;
        }

        .course-selection select {
            padding: 12px 16px;
            font-size: var(--font-size-base);
            border: 2px solid var(--background-color-gray);
            border-radius: 8px;
            background-color: var(--background-color-white);
            color: var(--text-color-black);
            min-width: 200px;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
        }


        .course-selection select:hover {
            border-color: var(--bfw-red);
        }

        .course-selection button:hover {
            background-color: var(--bfw-red);
            color: var(--text-color-white);
            box-shadow: 0 4px 12px rgba(226, 0, 26, 0.3);
        }

        .course-selection button:active {
            transform: translateY(0);
        }

        footer {
            background-color: var(--background-color-white);
            color: var(--text-color-gray);
            border-top: 1px solid var(--background-color-gray);
            font-size: 14px;
        }

    </style>
</head>
<body>

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Willkommen</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings-icon.svg" alt="Einstellungen">
    </header>


    <main>
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
    </main>

    <footer class="d-flex-c">
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>