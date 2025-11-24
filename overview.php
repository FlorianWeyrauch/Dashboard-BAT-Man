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
        main {
            padding: 30px 50px;
            display: flex;
            flex-direction: column;
        }

        .main-headline {
            text-align: center;
            margin-bottom: 24px;
        }

        .settings-icon {
            transition: transform 0.3s ease;
        }

        .settings-icon:hover {
            transform: rotate(45deg);
        }

        .course-selection {
            gap: 24px;
            margin-bottom: 24px;
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

        #course_overview {
            padding: 10px;
            flex: 1;
            overflow: auto;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 32px;
            scrollbar-width: thin;
            scrollbar-color: var(--bfw-red) var(--background-color-lightgray);
        }

        /* Custom Scrollbar Design */
        #course_overview::-webkit-scrollbar {
            width: 16px;
        }

        #course_overview::-webkit-scrollbar-track {
            background: var(--background-color-lightgray);
            border-radius: 8px;
        }

        #course_overview::-webkit-scrollbar-thumb {
            background: var(--bfw-red);
            border-radius: 8px;
            border: 2px solid var(--background-color-lightgray);
        }

        #course_overview::-webkit-scrollbar-thumb:hover {
            background: var(--text-color-gray);
        }

        #course_overview::-webkit-scrollbar-thumb:active {
            background: var(--text-color-black);
        }

        .course-card {
            width: 300px;
            height: 120px;
            flex-direction: column;
            border: 2px solid var(--bfw-red);
            background-color: var(--background-color-white);
            border-radius: 16px;
            padding: 24px;
        }

        .course-card-title {
            font-weight: bold;
        }

        p {
            margin-bottom: 0;
        }
    </style>
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

            <div onclick="" class="course-card d-flex-c">
                <h3 class="course-card-title">IT2024/07</h3>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

            <div onclick="" class="course-card d-flex-c">
                <h2 class="course-card-title">IT2024/07</h2>
                <p>Max Mustermann / Klausi Mausi</p>
            </div>

        </div>
    </main>

    <footer>
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>