<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summit Seeker - Untergebiet Routen</title>
    <link rel="stylesheet" href="styles/styles_general.css">  
    <link rel="stylesheet" href="styles/styles_filters.css"> 
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="assets/background-video.mp4" type="video/mp4">
    </video>

    <header>
        <h1>Summit Seeker</h1>
        <nav>
            <button onclick="window.location.href='index.php'">Home</button>
            <button>Über uns</button>
            <button>Leistungen</button>
            <button onclick="window.location.href='addRouteApp.php'">Routen</button>
            <button onclick="window.location.href='login.html'">Dein Konto</button>
        </nav>
    </header>

    <div>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "maRJN6D12bWB";
        $dbname = "climbingroutes_db";
        
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $untergebiets_id = intval($_GET['id']);

        // Informationen zum Untergebiet abrufen
        $untergebiet_stmt = $pdo->prepare("SELECT untergebiets_name FROM UnterGebiete WHERE untergebiets_id = :id");
        $untergebiet_stmt->execute(['id' => $untergebiets_id]);
        $untergebiet = $untergebiet_stmt->fetch();

        if (!$untergebiet) {
            echo "<p>Ungültiges Gebiet.</p>";
            exit;
        }

        // Den Namen des Untergebiets anzeigen
        echo "<h2>Gebiet: " . $untergebiet['untergebiets_name'] . "</h2>";

        // Routen des Untergebiets abrufen
        $sqlQuery = "
            SELECT Routen.routen_id, Routen.routen_name, Routen.routen_beschreibung 
            FROM Routen
            JOIN Sektoren ON Routen.sektor_id = Sektoren.sektor_id
            JOIN UnterGebiete ON Sektoren.untergebiets_id = UnterGebiete.untergebiets_id
            WHERE UnterGebiete.untergebiets_id = :untergebiets_id
            ORDER BY Routen.routen_name
        ";

        $stmt = $pdo->prepare($sqlQuery);
        $stmt->execute(['untergebiets_id' => $untergebiets_id]);

        if ($stmt->rowCount() > 0) {
            echo "<div class='route-list'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<a href='route_details.php?id=" . htmlspecialchars($row['routen_id']) . "' class='route-preview'>";
                echo "<h4>" . htmlspecialchars($row["routen_name"]) . "</h4>";
                echo "<p>" . htmlspecialchars($row["routen_beschreibung"]) . "</p>";
                echo "</a>";
            }
            echo "</div>";
        } else {
            echo "<p>Keine Routen in diesem Untergebiet gefunden.</p>";
        }
        ?>
    </div>
</body>
</html>
