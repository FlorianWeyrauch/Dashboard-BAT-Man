<?php
    //get database data for dashboard
    header('Content-Type => application/json; charset=utf-8');
    $production_mode = filter_var($_POST['prod'], FILTER_VALIDATE_BOOLEAN);
    
    if($production_mode === true){
        $host = "127.0.0.1";
        $user = "batman";
        $pass = "batman";
        $db   = "it202407";

        try {
            $conn = new mysqli($host, $user, $pass, $db);
            if ($conn->connect_error) {
                http_response_code(500);
                echo json_encode(['error' => true, 'message' => 'Connection failed: ' . $conn->connect_error]);
                exit;
            }
            
            $courses = [];
            
            // Alle aktiven Kurse abrufen
            $kurs_sql = "SELECT * FROM Kurs WHERE Aktiv = 1 ORDER BY Name DESC";
            $kurs_result = $conn->query($kurs_sql);
            
            if ($kurs_result && $kurs_result->num_rows > 0) {
                while($kurs = $kurs_result->fetch_assoc()) {
                    
                    // Ausbilder aus Teilnehmer-Tabelle mit Rolle "Ausbilder" für diesen Kurs abrufen
                    $ausbilder_sql = "SELECT t.Vorname, t.Nachname 
                                     FROM Teilnehmer t 
                                     WHERE t.Rolle_ID = 2 AND t.Kurs_ID = " . $kurs['Kurs_ID'] . "
                                     ORDER BY t.Teilnehmer_ID LIMIT 2";
                    $ausbilder_result = $conn->query($ausbilder_sql);
                    
                    $firstLeader = ["firstName" => "N/A", "lastName" => "N/A"];
                    $secondLeader = ["firstName" => "N/A", "lastName" => "N/A"];
                    
                    if ($ausbilder_result && $ausbilder_result->num_rows > 0) {
                        $count = 0;
                        while(($ausbilder = $ausbilder_result->fetch_assoc()) && $count < 2) {
                            $leader_data = [
                                "firstName" => $ausbilder['Vorname'],
                                "lastName" => $ausbilder['Nachname']
                            ];
                            
                            if ($count == 0) {
                                $firstLeader = $leader_data;
                            } else {
                                $secondLeader = $leader_data;
                            }
                            $count++;
                        }
                    }
                    
                    // Teilnehmer für diesen Kurs abrufen (nur echte Teilnehmer, keine Admins oder Ausbilder)
                    $teilnehmer_sql = "
                        SELECT t.Vorname, t.Nachname, f.Kuerzel as Fachrichtung
                        FROM Teilnehmer t
                        LEFT JOIN Fachrichtung f ON t.Fachrichtung_ID = f.Fachrichtung_ID
                        WHERE t.Kurs_ID = " . $kurs['Kurs_ID'] . " AND t.Rolle_ID NOT IN (1, 2)";
                        
                    $teilnehmer_result = $conn->query($teilnehmer_sql);
                    
                    $students = [];
                    if ($teilnehmer_result && $teilnehmer_result->num_rows > 0) {
                        while($teilnehmer = $teilnehmer_result->fetch_assoc()) {
                            // Zufälligen Status zuweisen (da keine Status-Zuordnung in DB erkennbar)
                            $status_options = ['red', 'yellow', 'green'];
                            $random_status = $status_options[array_rand($status_options)];
                            
                            $students[] = [
                                "firstName" => $teilnehmer['Vorname'],
                                "lastName" => $teilnehmer['Nachname'],
                                "profession" => $teilnehmer['Fachrichtung'] ?: 'FIAE',
                                "status" => $random_status
                            ];
                        }
                    }
                    
                    // Kurs-Array erstellen
                    $courses[] = [
                        "courseName" => $kurs['Name'],
                        "firstLeader" => $firstLeader,
                        "secondLeader" => $secondLeader,
                        "students" => $students
                    ];
                }
            }
            
            $conn->close();
            
            // Wenn keine Kurse gefunden, Fallback auf Testdaten
            if (empty($courses)) {
                $courses = [["courseName" => "IT202407", "message" => "Keine Kursdaten in DB gefunden"]];
            }
            
            echo json_encode($courses, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => true, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
    $courses = [
        [
        "courseName" => "IT202401",
        "firstLeader" => ["firstName" => "Thomas", "lastName" => "Bauer"],
        "secondLeader" => ["firstName" => "Maria", "lastName" => "Klein"],
        "students" => [
            ["firstName" => "Leon", "lastName" => "Wagner", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-15", "companyName" => "TechCorp GmbH", "location" => "München"],
                ["status" => "absage", "date" => "2024-10-20", "companyName" => "DataSoft AG", "location" => "Hamburg"],
                ["status" => "zusage", "date" => "2024-11-01", "companyName" => "CodeWorks", "location" => "Berlin"]
            ]],
            ["firstName" => "Emma", "lastName" => "Koch", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-20", "companyName" => "NetSystems", "location" => "Frankfurt"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CloudTech", "location" => "Köln"],
                ["status" => "zusage", "date" => "2024-11-10", "companyName" => "IT Solutions", "location" => "Stuttgart"],
                ["status" => "absage", "date" => "2024-10-25", "companyName" => "TechFlow", "location" => "Düsseldorf"]
            ]],
            ["firstName" => "Felix", "lastName" => "Richter", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-22", "companyName" => "DigitalMedia Pro", "location" => "Leipzig"],
                ["status" => "email", "date" => "2024-11-12", "companyName" => "Creative Studios", "location" => "Dresden"],
                ["status" => "absage", "date" => "2024-10-30", "companyName" => "Design House", "location" => "Nürnberg"]
            ]],
            ["firstName" => "Hannah", "lastName" => "Groß", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-25", "companyName" => "SoftDev Inc", "location" => "Hannover"],
                ["status" => "zusage", "date" => "2024-11-20", "companyName" => "AppCreators", "location" => "Bremen"],
                ["status" => "telefon", "date" => "2024-11-15", "companyName" => "WebSolutions", "location" => "Dortmund"],
                ["status" => "absage", "date" => "2024-11-05", "companyName" => "CodeFactory", "location" => "Essen"]
            ]],
            ["firstName" => "Jan", "lastName" => "König", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-19", "companyName" => "NetworkPro", "location" => "Mannheim"],
                ["status" => "telefon", "date" => "2024-11-14", "companyName" => "SystemsPlus", "location" => "Karlsruhe"],
                ["status" => "absage", "date" => "2024-10-28", "companyName" => "TechSupport", "location" => "Wiesbaden"]
            ]],
            ["firstName" => "Paula", "lastName" => "Pfeiffer", "profession" => "FIDM", "applications" => [
                ["status" => "zusage", "date" => "2024-11-21", "companyName" => "MediaCraft", "location" => "Augsburg"],
                ["status" => "email", "date" => "2024-11-16", "companyName" => "VisualArts", "location" => "Münster"],
                ["status" => "telefon", "date" => "2024-11-11", "companyName" => "DigitalDesign", "location" => "Freiburg"],
                ["status" => "absage", "date" => "2024-11-03", "companyName" => "CreativeSpace", "location" => "Rostock"]
            ]],
            ["firstName" => "Moritz", "lastName" => "Hahn", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-18", "companyName" => "DevTeam", "location" => "Kiel"],
                ["status" => "telefon", "date" => "2024-11-13", "companyName" => "CodeBase", "location" => "Magdeburg"],
                ["status" => "email", "date" => "2024-11-08", "companyName" => "SoftwareLab", "location" => "Erfurt"]
            ]],
            ["firstName" => "Lara", "lastName" => "Engel", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-23", "companyName" => "ITConsult", "location" => "Mainz"],
                ["status" => "zusage", "date" => "2024-11-17", "companyName" => "TechService", "location" => "Saarbrücken"],
                ["status" => "telefon", "date" => "2024-11-12", "companyName" => "NetworkMax", "location" => "Potsdam"],
                ["status" => "absage", "date" => "2024-11-01", "companyName" => "SystemTech", "location" => "Schwerin"]
            ]],
            ["firstName" => "Simon", "lastName" => "Frank", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-20", "companyName" => "MediaTech", "location" => "Oldenburg"],
                ["status" => "email", "date" => "2024-11-15", "companyName" => "DesignLab", "location" => "Osnabrück"],
                ["status" => "absage", "date" => "2024-11-07", "companyName" => "CreativeTech", "location" => "Göttingen"]
            ]],
            ["firstName" => "Julia", "lastName" => "Krause", "profession" => "FIAE", "applications" => [
                ["status" => "zusage", "date" => "2024-11-24", "companyName" => "AppDev", "location" => "Heidelberg"],
                ["status" => "email", "date" => "2024-11-19", "companyName" => "CodeCraft", "location" => "Regensburg"],
                ["status" => "telefon", "date" => "2024-11-14", "companyName" => "SoftwarePlus", "location" => "Würzburg"],
                ["status" => "absage", "date" => "2024-11-06", "companyName" => "TechBuild", "location" => "Ingolstadt"]
            ]],
            ["firstName" => "Till", "lastName" => "Vogt", "profession" => "FISI", "applications" => [
                ["status" => "telefon", "date" => "2024-11-22", "companyName" => "NetworX", "location" => "Ulm"],
                ["status" => "email", "date" => "2024-11-17", "companyName" => "SystemsPro", "location" => "Heilbronn"],
                ["status" => "zusage", "date" => "2024-11-12", "companyName" => "ITExperts", "location" => "Pforzheim"]
            ]],
            ["firstName" => "Lea", "lastName" => "Kaiser", "profession" => "FIDM", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-21", "companyName" => "DigitalArt", "location" => "Reutlingen"],
                ["status" => "zusage", "date" => "2024-11-16", "companyName" => "MediaWorks", "location" => "Tübingen"],
                ["status" => "telefon", "date" => "2024-11-11", "companyName" => "DesignStudio", "location" => "Konstanz"],
                ["status" => "email", "date" => "2024-11-05", "companyName" => "CreativeMedia", "location" => "Ravensburg"]
            ]],
            ["firstName" => "Nico", "lastName" => "Horn", "profession" => "FIAE", "applications" => [
                ["status" => "email", "date" => "2024-11-23", "companyName" => "DevCorp", "location" => "Aachen"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CodeSpace", "location" => "Bonn"],
                ["status" => "absage", "date" => "2024-11-09", "companyName" => "SoftTech", "location" => "Leverkusen"]
            ]],
            ["firstName" => "Mara", "lastName" => "Sommer", "profession" => "FISI", "applications" => [
                ["status" => "zusage", "date" => "2024-11-25", "companyName" => "NetworkSol", "location" => "Mönchengladbach"],
                ["status" => "email", "date" => "2024-11-20", "companyName" => "TechCenter", "location" => "Krefeld"],
                ["status" => "telefon", "date" => "2024-11-15", "companyName" => "SystemMax", "location" => "Oberhausen"],
                ["status" => "absage", "date" => "2024-11-08", "companyName" => "ITService", "location" => "Duisburg"]
            ]],
            ["firstName" => "Erik", "lastName" => "Böhm", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-24", "companyName" => "MediaPlus", "location" => "Gelsenkirchen"],
                ["status" => "email", "date" => "2024-11-19", "companyName" => "DesignMax", "location" => "Bochum"],
                ["status" => "zusage", "date" => "2024-11-13", "companyName" => "CreativeLab", "location" => "Herne"]
            ]],
            ["firstName" => "Nora", "lastName" => "Weiß", "profession" => "FIAE", "applications" => [
                ["status" => "absage", "date" => "2024-11-22", "companyName" => "AppSoft", "location" => "Recklinghausen"],
                ["status" => "telefon", "date" => "2024-11-17", "companyName" => "CodeMax", "location" => "Bottrop"],
                ["status" => "email", "date" => "2024-11-12", "companyName" => "DevMax", "location" => "Gladbeck"],
                ["status" => "zusage", "date" => "2024-11-07", "companyName" => "SoftMax", "location" => "Dorsten"]
            ]],
            ["firstName" => "Theo", "lastName" => "Scholz", "profession" => "FISI", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-26", "companyName" => "TechMax", "location" => "Marl"],
                ["status" => "zusage", "date" => "2024-11-21", "companyName" => "NetworkPlus", "location" => "Haltern"],
                ["status" => "email", "date" => "2024-11-16", "companyName" => "SystemPlus", "location" => "Castrop-Rauxel"]
            ]],
            ["firstName" => "Maya", "lastName" => "Friedrich", "profession" => "FIDM", "applications" => [
                ["status" => "email", "date" => "2024-11-25", "companyName" => "DesignPro", "location" => "Waltrop"],
                ["status" => "telefon", "date" => "2024-11-20", "companyName" => "MediaMax", "location" => "Lünen"],
                ["status" => "zusage", "date" => "2024-11-14", "companyName" => "CreativeMax", "location" => "Bergkamen"],
                ["status" => "absage", "date" => "2024-11-09", "companyName" => "ArtStudio", "location" => "Kamen"]
            ]],
            ["firstName" => "Robin", "lastName" => "Jansen", "profession" => "FIAE", "applications" => [
                ["status" => "telefon", "date" => "2024-11-26", "companyName" => "CodePro", "location" => "Unna"],
                ["status" => "email", "date" => "2024-11-21", "companyName" => "DevPro", "location" => "Hamm"],
                ["status" => "absage", "date" => "2024-11-15", "companyName" => "SoftPro", "location" => "Soest"]
            ]],
            ["firstName" => "Ida", "lastName" => "Stein", "profession" => "FISI", "applications" => [
                ["status" => "zusage", "date" => "2024-11-27", "companyName" => "NetworkPro", "location" => "Arnsberg"],
                ["status" => "email", "date" => "2024-11-22", "companyName" => "TechPro", "location" => "Iserlohn"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "SystemPro", "location" => "Lüdenscheid"],
                ["status" => "absage", "date" => "2024-11-13", "companyName" => "ITMax", "location" => "Hagen"]
            ]]
        ]
    ],
    [
        "courseName" => "IT202407",
        "firstLeader" => ["firstName" => "Thomas", "lastName" => "Bauer"],
        "secondLeader" => ["firstName" => "Maria", "lastName" => "Klein"],
        "students" => [
            ["firstName" => "Leon", "lastName" => "Wagner", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-15", "companyName" => "TechCorp GmbH", "location" => "München"],
                ["status" => "absage", "date" => "2024-10-20", "companyName" => "DataSoft AG", "location" => "Hamburg"],
                ["status" => "zusage", "date" => "2024-11-01", "companyName" => "CodeWorks", "location" => "Berlin"]
            ]],
            ["firstName" => "Emma", "lastName" => "Koch", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-20", "companyName" => "NetSystems", "location" => "Frankfurt"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CloudTech", "location" => "Köln"],
                ["status" => "zusage", "date" => "2024-11-10", "companyName" => "IT Solutions", "location" => "Stuttgart"],
                ["status" => "absage", "date" => "2024-10-25", "companyName" => "TechFlow", "location" => "Düsseldorf"],
                ["status" => "email", "date" => "2024-11-20", "companyName" => "NetSystems", "location" => "Frankfurt"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CloudTech", "location" => "Köln"],
                ["status" => "zusage", "date" => "2024-11-10", "companyName" => "IT Solutions", "location" => "Stuttgart"],
                ["status" => "absage", "date" => "2024-10-25", "companyName" => "TechFlow", "location" => "Düsseldorf"],
                ["status" => "email", "date" => "2024-11-20", "companyName" => "NetSystems", "location" => "Frankfurt"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CloudTech", "location" => "Köln"],
                ["status" => "telefon", "date" => "2024-11-10", "companyName" => "IT Solutions", "location" => "Stuttgart"],
                ["status" => "absage", "date" => "2024-10-25", "companyName" => "TechFlow", "location" => "Düsseldorf"]
            ]],
            ["firstName" => "Felix", "lastName" => "Richter", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-22", "companyName" => "DigitalMedia Pro", "location" => "Leipzig"],
                ["status" => "email", "date" => "2024-11-12", "companyName" => "Creative Studios", "location" => "Dresden"],
                ["status" => "absage", "date" => "2024-10-30", "companyName" => "Design House", "location" => "Nürnberg"]
            ]],
            ["firstName" => "Hannah", "lastName" => "Groß", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-25", "companyName" => "SoftDev Inc", "location" => "Hannover"],
                ["status" => "zusage", "date" => "2024-11-20", "companyName" => "AppCreators", "location" => "Bremen"],
                ["status" => "telefon", "date" => "2024-11-15", "companyName" => "WebSolutions", "location" => "Dortmund"],
                ["status" => "absage", "date" => "2024-11-05", "companyName" => "CodeFactory", "location" => "Essen"]
            ]],
            ["firstName" => "Jan", "lastName" => "König", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-19", "companyName" => "NetworkPro", "location" => "Mannheim"],
                ["status" => "telefon", "date" => "2024-11-14", "companyName" => "SystemsPlus", "location" => "Karlsruhe"],
                ["status" => "absage", "date" => "2024-10-28", "companyName" => "TechSupport", "location" => "Wiesbaden"]
            ]],
            ["firstName" => "Paula", "lastName" => "Pfeiffer", "profession" => "FIDM", "applications" => [
                ["status" => "zusage", "date" => "2024-11-21", "companyName" => "MediaCraft", "location" => "Augsburg"],
                ["status" => "email", "date" => "2024-11-16", "companyName" => "VisualArts", "location" => "Münster"],
                ["status" => "telefon", "date" => "2024-11-11", "companyName" => "DigitalDesign", "location" => "Freiburg"],
                ["status" => "absage", "date" => "2024-11-03", "companyName" => "CreativeSpace", "location" => "Rostock"]
            ]],
            ["firstName" => "Moritz", "lastName" => "Hahn", "profession" => "FIAE", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-18", "companyName" => "DevTeam", "location" => "Kiel"],
                ["status" => "telefon", "date" => "2024-11-13", "companyName" => "CodeBase", "location" => "Magdeburg"],
                ["status" => "email", "date" => "2024-11-08", "companyName" => "SoftwareLab", "location" => "Erfurt"]
            ]],
            ["firstName" => "Lara", "lastName" => "Engel", "profession" => "FISI", "applications" => [
                ["status" => "email", "date" => "2024-11-23", "companyName" => "ITConsult", "location" => "Mainz"],
                ["status" => "zusage", "date" => "2024-11-17", "companyName" => "TechService", "location" => "Saarbrücken"],
                ["status" => "telefon", "date" => "2024-11-12", "companyName" => "NetworkMax", "location" => "Potsdam"],
                ["status" => "absage", "date" => "2024-11-01", "companyName" => "SystemTech", "location" => "Schwerin"]
            ]],
            ["firstName" => "Simon", "lastName" => "Frank", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-20", "companyName" => "MediaTech", "location" => "Oldenburg"],
                ["status" => "email", "date" => "2024-11-15", "companyName" => "DesignLab", "location" => "Osnabrück"],
                ["status" => "absage", "date" => "2024-11-07", "companyName" => "CreativeTech", "location" => "Göttingen"]
            ]],
            ["firstName" => "Julia", "lastName" => "Krause", "profession" => "FIAE", "applications" => [
                ["status" => "zusage", "date" => "2024-11-24", "companyName" => "AppDev", "location" => "Heidelberg"],
                ["status" => "email", "date" => "2024-11-19", "companyName" => "CodeCraft", "location" => "Regensburg"],
                ["status" => "telefon", "date" => "2024-11-14", "companyName" => "SoftwarePlus", "location" => "Würzburg"],
                ["status" => "absage", "date" => "2024-11-06", "companyName" => "TechBuild", "location" => "Ingolstadt"]
            ]],
            ["firstName" => "Till", "lastName" => "Vogt", "profession" => "FISI", "applications" => [
                ["status" => "telefon", "date" => "2024-11-22", "companyName" => "NetworX", "location" => "Ulm"],
                ["status" => "email", "date" => "2024-11-17", "companyName" => "SystemsPro", "location" => "Heilbronn"],
                ["status" => "zusage", "date" => "2024-11-12", "companyName" => "ITExperts", "location" => "Pforzheim"]
            ]],
            ["firstName" => "Lea", "lastName" => "Kaiser", "profession" => "FIDM", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-21", "companyName" => "DigitalArt", "location" => "Reutlingen"],
                ["status" => "zusage", "date" => "2024-11-16", "companyName" => "MediaWorks", "location" => "Tübingen"],
                ["status" => "telefon", "date" => "2024-11-11", "companyName" => "DesignStudio", "location" => "Konstanz"],
                ["status" => "email", "date" => "2024-11-05", "companyName" => "CreativeMedia", "location" => "Ravensburg"]
            ]],
            ["firstName" => "Nico", "lastName" => "Horn", "profession" => "FIAE", "applications" => [
                ["status" => "email", "date" => "2024-11-23", "companyName" => "DevCorp", "location" => "Aachen"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "CodeSpace", "location" => "Bonn"],
                ["status" => "absage", "date" => "2024-11-09", "companyName" => "SoftTech", "location" => "Leverkusen"]
            ]],
            ["firstName" => "Mara", "lastName" => "Sommer", "profession" => "FISI", "applications" => [
                ["status" => "zusage", "date" => "2024-11-25", "companyName" => "NetworkSol", "location" => "Mönchengladbach"],
                ["status" => "email", "date" => "2024-11-20", "companyName" => "TechCenter", "location" => "Krefeld"],
                ["status" => "telefon", "date" => "2024-11-15", "companyName" => "SystemMax", "location" => "Oberhausen"],
                ["status" => "absage", "date" => "2024-11-08", "companyName" => "ITService", "location" => "Duisburg"]
            ]],
            ["firstName" => "Erik", "lastName" => "Böhm", "profession" => "FIDM", "applications" => [
                ["status" => "telefon", "date" => "2024-11-24", "companyName" => "MediaPlus", "location" => "Gelsenkirchen"],
                ["status" => "email", "date" => "2024-11-19", "companyName" => "DesignMax", "location" => "Bochum"],
                ["status" => "zusage", "date" => "2024-11-13", "companyName" => "CreativeLab", "location" => "Herne"]
            ]],
            ["firstName" => "Nora", "lastName" => "Weiß", "profession" => "FIAE", "applications" => [
                ["status" => "absage", "date" => "2024-11-22", "companyName" => "AppSoft", "location" => "Recklinghausen"],
                ["status" => "telefon", "date" => "2024-11-17", "companyName" => "CodeMax", "location" => "Bottrop"],
                ["status" => "email", "date" => "2024-11-12", "companyName" => "DevMax", "location" => "Gladbeck"],
                ["status" => "zusage", "date" => "2024-11-07", "companyName" => "SoftMax", "location" => "Dorsten"]
            ]],
            ["firstName" => "Theo", "lastName" => "Scholz", "profession" => "FISI", "applications" => [
                ["status" => "vertrag unterschrieben", "date" => "2024-11-26", "companyName" => "TechMax", "location" => "Marl"],
                ["status" => "zusage", "date" => "2024-11-21", "companyName" => "NetworkPlus", "location" => "Haltern"],
                ["status" => "email", "date" => "2024-11-16", "companyName" => "SystemPlus", "location" => "Castrop-Rauxel"]
            ]],
            ["firstName" => "Maya", "lastName" => "Friedrich", "profession" => "FIDM", "applications" => [
                ["status" => "email", "date" => "2024-11-25", "companyName" => "DesignPro", "location" => "Waltrop"],
                ["status" => "telefon", "date" => "2024-11-20", "companyName" => "MediaMax", "location" => "Lünen"],
                ["status" => "zusage", "date" => "2024-11-14", "companyName" => "CreativeMax", "location" => "Bergkamen"],
                ["status" => "absage", "date" => "2024-11-09", "companyName" => "ArtStudio", "location" => "Kamen"]
            ]],
            ["firstName" => "Robin", "lastName" => "Jansen", "profession" => "FIAE", "applications" => [
                ["status" => "telefon", "date" => "2024-11-26", "companyName" => "CodePro", "location" => "Unna"],
                ["status" => "email", "date" => "2024-11-21", "companyName" => "DevPro", "location" => "Hamm"],
                ["status" => "absage", "date" => "2024-11-15", "companyName" => "SoftPro", "location" => "Soest"]
            ]],
            ["firstName" => "Ida", "lastName" => "Stein", "profession" => "FISI", "applications" => [
                ["status" => "zusage", "date" => "2024-11-27", "companyName" => "NetworkPro", "location" => "Arnsberg"],
                ["status" => "email", "date" => "2024-11-22", "companyName" => "TechPro", "location" => "Iserlohn"],
                ["status" => "telefon", "date" => "2024-11-18", "companyName" => "SystemPro", "location" => "Lüdenscheid"],
                ["status" => "absage", "date" => "2024-11-13", "companyName" => "ITMax", "location" => "Hagen"]
            ]]
        ]
    ],
    
];
echo json_encode($courses, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
    
?>

