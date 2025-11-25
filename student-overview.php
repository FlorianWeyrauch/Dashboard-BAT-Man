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
    
    <!-- JavaScript-Dateien -->
     <script defer src="./js/test-daten.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/session.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/template.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/main.js?v=<?php echo time(); ?>"></script>
    <script defer src="./node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
</head>

<body> <!-- onload="loadStudentOverview()" -->

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Dashboard</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings.svg" alt="Einstellungen">
    </header>


    <main id="student_overview">
        <div class="d-flex-c-c">
            <h2>IT2024/24</h2>
            <p>${firstTeacher} / ${secondTeacher}</p>
        </div>

        <div class="d-flex-c filter-bar">
            <input placeholder="Suche nach Namen..." type="text">
            <select oninput="filterCourses()" name="courses" id="courses_selection">
                <option value="" disabled selected hidden>Status auswählen</option>
                <option value="red">Rot</option>
                <option value="yellow">Gelb</option>
                <option value="green">Grün</option>
            </select>

            <select oninput="filterCourses()" name="courses" id="courses_selection">
                <option value="" disabled selected hidden>Beruf auswählen</option>
                <option value="fiae">FIAE</option>
                <option value="fisi">FISI</option>
                <option value="itdm">ITDM</option>
            </select>
        </div>
        
        <div class="wrapper d-flex-sb-fs">
            <!-- Schueler ansicht -->
            <div class="course-student-display d-flex-sb-c">
                <h4>Florian Weyrauch</h4>
                <h4>FIAE</h4>
                <div class="status-traffic-light"></div>
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
</body>
</html>