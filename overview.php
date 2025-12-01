<?php
// Datenbank-Verbindungstest
$host = "192.168.9.123";
$user = "it202407";
$pass = "batman";
$db   = "batman";

echo "<script>console.log('DB Connection Test started...');</script>";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        $error = addslashes($conn->connect_error);
        echo "<script>console.error('Connection failed: $error');</script>";
    } else {
        $serverInfo = addslashes($conn->server_info);
        $hostInfo = addslashes($conn->host_info);
        echo "<script>console.log('✅ Database connection successful!');</script>";
        echo "<script>console.log('Server Info: $serverInfo');</script>";
        echo "<script>console.log('Host Info: $hostInfo');</script>";
        $conn->close();
    }
} catch (Exception $e) {
    $message = addslashes($e->getMessage());
    echo "<script>console.error('❌ Exception: $message');</script>";
}
?>

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

</head>
<body onload="init()">

    <header class="d-flex-sb-c">
        <a href="./overview.php">
            <img class="bfw-icon" src="./assets/icon/bfw-icon.svg" alt="BFW">
        </a>
        <h1>Dashboard</h1>
        <img class="settings-icon c-pointer" src="./assets/icon/settings.svg" alt="Einstellungen">
    </header>


    <main>
        <h2 id="welcome_message" class="main-headline"></h2>
        <!-- js dynamische ausgabe -->
        <div class="course-selection d-flex-c">
            <select oninput="filterCourses()" name="courses" id="courses_selection">
                
            </select>
            <button onclick="loadCourses()" class="">Zurücksetzen</button>
        </div>

        <!-- Kursübersicht -->
        <div id="course_overview">
            <!-- Dynamisch generierte Kurskarten werden hier eingefügt -->
        </div>
    </main>

    <footer>
        <div>© 2025 Berufsförderungswerk Nürnberg GmbH</div>
    </footer>
        <!-- JavaScript-Dateien -->
    <script src="./js/jQueryv3.7.1.min.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/get_db.js?v=<?php echo time(); ?>"></script>
     <script defer src="./js/session.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/template.js?v=<?php echo time(); ?>"></script>
    <script defer src="./js/main.js?v=<?php echo time(); ?>"></script>
    <script defer src="./node_modules\bootstrap\dist\js\bootstrap.min.js"></script>
</body>
</html>