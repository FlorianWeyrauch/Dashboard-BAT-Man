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
    <link rel="stylesheet" href="./css/student-overview.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/standard.css?v=<?php echo time(); ?>">
    
</head>

<body onload="loadCurrentStudents()"> <!-- onload="loadStudentOverview()" -->

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Dashboard</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings.svg" alt="Einstellungen">
    </header>


    <main id="student_overview">
        <div class="d-flex-c-c" id="course_header">
            <!-- Dynamische Kursanzeige + Kursleiter -->
        </div>

        <div class="d-flex-c filter-bar">
            <input oninput="filterStudent()" id="name_input" placeholder="Suche nach Nachnamen..." type="text">

            <select oninput="filterStudent()" id="profession_selection">
                <option value="" disabled selected hidden>Beruf auswählen</option>
                <option value="fiae">FIAE</option>
                <option value="fisi">FISI</option>
                <option value="fidm">FIDM</option>
            </select>

            <select oninput="filterStudent()" id="status_selection">
                <option value="" disabled selected hidden>Status auswählen</option>
                <option value="rot" data-color="red">● Rot</option>
                <option value="gelb" data-color="yellow">● Gelb</option>
                <option value="grün" data-color="green">● Grün</option>
            </select>

            <button onclick="loadCurrentStudents()">Zurücksetzen</button>
        </div>
        
        <div class="wrapper d-flex-sb-fs">
            <!-- Schueler ansicht -->
            <div class="course-student-display" id="course_student_display">
                <!-- Dynamisch generierte Schülerkarten werden hier eingefügt -->
            </div>

            <!-- Kreisdiagramm -->
            <div class="course-diagram">
                Diagramm
            </div>
        </div>
    </main>

    <footer>
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>

    <!-- JavaScript-Dateien -->
    <script defer src="./js/session.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/template.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/studentOverview.js?v=<?php echo time(); ?>"></script>
    <script defer src="./node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
</body>
</html>