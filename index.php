<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Summit Seeker</title>
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
            <button onclick="window.location.href='account/account.php'">Dein Konto</button>
        </nav>
    </header>

    <div>
        <h2>
            Entdecke deine nächste <br>Herausforderung mit
            Summit Seeker
        </h2>
    </div>

    <div>
    <form method="post" action="">
            <select name="schwierigkeitsgrad">
                <option value="">Alle Schwierigkeitsgrade</option>
                <option value="1-3">1-3</option>
                <option value="4a">4a</option>
                <option value="4b">4b</option>
                <option value="4c">4c</option>
                <option value="5a">5a</option>
                <option value="5b">5b</option>
                <option value="5c">5c</option>
                <option value="6a">6a</option>
                <option value="6a+">6a+</option>
                <option value="6b">6b</option>
                <option value="6b+">6b+</option>
                <option value="6c">6c</option>
                <option value="6c+">6c+</option>
                <option value="7a">7a</option>
                <option value="7a+">7a+</option>
                <option value="7b">7b</option>
                <option value="7b+">7b+</option>
                <option value="7c">7c</option>
                <option value="7c+">7c+</option>
                <option value="8a">8a</option>
                <option value="8a+">8a+</option>
                <option value="8b">8b</option>
                <option value="8b+">8b+</option>
                <option value="8c">8c</option>
                <option value="8c+">8c+</option>
                <option value="9a">9a</option>
                <option value="9a+">9a+</option>
                <option value="9b">9b</option>
                <option value="9b+">9b+</option>
                <option value="9c">9c</option>
            </select>
            <select name="anfängerfreundlich">
                <option value="">Anfängerfreundlich</option>
                <option value="Ja">Ja</option>
                <option value="Nein">Nein</option>
            </select>
            <select name="regensicher">
                <option value="">Regensicher</option>
                <option value="Ja">Ja</option>
                <option value="Nein">Nein</option>
            </select>
            <select name="besucherandrang">
                <option value="">Besucherandrang</option>
                <option value="Sehr Stark">Sehr Stark</option>
                <option value="Stark">Stark</option>
                <option value="Mittel">Mittel</option>
                <option value="Schwach">Schwach</option>
            </select>
            <select name="technik">
                <option value="">Technik</option>
                <option value="gutgriffig">Gutgriffig</option>
                <option value="athletisch">Athletisch</option>
                <option value="abgespeckt">Abgespeckt</option>
                <option value="runout">Runout</option>
                <option value="schwierig">Schwierig</option>
                <option value="superschwer">Superschwer</option>
                <option value="technisch">Technisch</option>
                <option value="einfach">Einfach</option>
                <option value="heikel">Heikel</option>
                <option value="schön">Schön</option>
                <option value="schlecht">Schlecht</option>
                <option value="klemmen">Klemmen</option>
                <option value="Ausdauer">Ausdauer</option>
                <option value="Gleichgewicht">Gleichgewicht</option>
                <option value="Kinder">Kinder</option>
            </select>
            <select name="felscharakteristik">
                <option value="">Felscharakteristik</option>
                <option value="Platte">Platte</option>
                <option value="Überhängend">Überhängend</option>
                <option value="Überhang">Überhang</option>
                <option value="Leisten">Leisten</option>
                <option value="Löcher">Löcher</option>
                <option value="Riss">Riss</option>
                <option value="Verschneidung">Verschneidung</option>
                <option value="Sinter">Sinter</option>
                <option value="Henkel">Henkel</option>
                <option value="Querung">Querung</option>
                <option value="Boulder">Boulder</option>
                <option value="Dach">Dach</option>
            </select>


            <input type="submit" name="submit" value="Suchen" class="filterbutton">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $host = "localhost";
            $username = "root";
            $password = "maRJN6D12bWB";
            $dbname = "climbingroutes_db";
            
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $schwierigkeitsgrad = $_POST['schwierigkeitsgrad'];
            $anfängerfreundlich = $_POST['anfängerfreundlich'];
            $regensicher = $_POST['regensicher'];
            $besucherandrang = $_POST['besucherandrang'];
            $technik = $_POST['technik'];
            $felscharakteristik = $_POST['felscharakteristik'];

            $sqlQuery = "SELECT Gebiete.gebiets_name, UnterGebiete.untergebiets_name, UnterGebiete.untergebiets_id,
                                Routen.routen_id, Routen.routen_name, Routen.routen_beschreibung 
                         FROM Gebiete 
                         JOIN UnterGebiete ON Gebiete.gebiets_id = UnterGebiete.gebiets_referenz
                         JOIN Sektoren ON UnterGebiete.untergebiets_id = Sektoren.untergebiets_id
                         JOIN Routen ON Sektoren.sektor_id = Routen.sektor_id";

            $conditions = [];

            if ($schwierigkeitsgrad) {
                $conditions[] = "Routen.schwierigkeit LIKE '$schwierigkeitsgrad%'";
            }
            if ($anfängerfreundlich) {
                $conditions[] = "UnterGebiete.anfaengerfreundlich = " . ($anfängerfreundlich === 'Ja') ? 1 : 0;
            }
            if ($regensicher) {
                $conditions[] = "UnterGebiete.regensicher = " . ($regensicher === 'Ja') ? 1 : 0;
            }
            if ($besucherandrang) {
                $conditions[] = "UnterGebiete.besucherandrang = '$besucherandrang'";
            }
            if ($technik) {
                $conditions[] = "Routen.routen_beschreibung LIKE '%$technik%'";
            }
            if ($felscharakteristik) {
                $conditions[] = "Routen.routen_beschreibung LIKE '%$felscharakteristik%'";
            }

            if (!empty($conditions)) {
                $sqlQuery .= " WHERE " . implode(' AND ', $conditions);
            }

            $sqlQuery .= " ORDER BY UnterGebiete.untergebiets_name, Routen.routen_name";

            // SQL-Query ausführen
            $stmt = $pdo->query($sqlQuery);
            $currentUntergebiet = "";
            $hasRoutes = false;

            // Daten verarbeiten
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Wenn das Untergebiet wechselt, schließe das alte ab und öffne ein neues
                if ($row['untergebiets_name'] !== $currentUntergebiet) {
                    if ($hasRoutes) {
                        echo "</div>";  // Schließe die Routen-Liste für das Untergebiet
                    }
                    // Neues Untergebiet öffnen
                    $currentUntergebiet = $row['untergebiets_name'];
                    
                    // Link für das Untergebiet erstellen
                    echo "<div class='untergebiet-preview'>";
                    echo "<a href='untergebiet_routes.php?id=" . $row['untergebiets_id'] . "'>";
                    echo "<h3>Gebiet: " . $row['untergebiets_name'] . "</h3>";
                    echo "</a>";
                    $hasRoutes = false; // Setze zurück
                }

                // Route anzeigen
                echo "<a href='route_details.php?id=" . $row['routen_id'] . "' class='route-preview'>";
                echo "<h4>" . $row["routen_name"] . "</h4>";
                echo "<p>" . $row["routen_beschreibung"] . "</p>";
                echo "</a>";
                $hasRoutes = true;
            }

            if ($hasRoutes) {
                echo "</div>"; // Schließe das letzte Untergebiet
            }

        }
        ?>
    </div>
</body>
</html>
