<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>Neue Route hinzufügen - Summit Seeker</title>
    <link rel="stylesheet" href="styles/styles_general.css">  
    <link rel="stylesheet" href="styles/styles_filters.css"> 
    
    <style>
        label {
            font-family: Arial, sans-serif;
            color: black;
        }
        h3 {
            color: black;
        }
        .route-detail {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            text-align: left;
        }
        form {
            display: flex;
            flex-direction: column; /*flex richtung vertikal*/  
            gap: 10px; 
        }
    </style>

</head>

<body>
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

    <video autoplay muted loop id="background-video">
        <source src="assets/background-video.mp4" type="video/mp4">
    </video>

    <div class='route-detail'>
        <h2>Neue Route hinzufügen</h2>
        <form action="" method="POST">
            <h3>Gebiet</h3>
            <label>Gebietsname:</label>
            <input type="text" name="gebiets_name" required>

            <h3>Untergebiet</h3>
            <label>Untergebietsname:</label>
            <input type="text" name="untergebiets_name" required>

            <label>Parkplatz-Koordinaten:</label>
            <input type="text" name="park_koordinaten" required>

            <label>Fels-Koordinaten:</label>
            <input type="text" name="fels_koordinaten" required>

            <label>Höhenmeter:</label>
            <input type="number" name="hoehenmeter" required>

            <label>Wandausrichtung:</label>
            <select name="wand_ausrichtung" required>
                <option value="Norden">Norden</option>
                <option value="Nordwest">Nordwest</option>
                <option value="Nordost">Nordost</option>
                <option value="Osten">Osten</option>
                <option value="Südost">Südost</option>
                <option value="Süden">Süden</option>
                <option value="Südwest">Südwest</option>
                <option value="Westen">Westen</option>
            </select>

            <label>Schönheitsbewertung:</label>
            <select name="schoenheit" required>
                <option value="wunderschön">wunderschön</option>
                <option value="schön">schön</option>
                <option value="empfehlenswert">empfehlenswert</option>
                <option value="mittelmäßig">mittelmäßig</option>
            </select>

            <label>Sicherheitsbewertung:</label>
            <select name="sicherheit_bewertung" required>
                <option value="sehr schlecht">sehr schlecht</option>
                <option value="vorsicht">vorsicht</option>
                <option value="gut">gut</option>
                <option value="ausgezeichnet">ausgezeichnet</option>
            </select>

            <label>Besucherandrang:</label>
            <select name="besucherandrang" required>
                <option value="schwach">schwach</option>
                <option value="mittel">mittel</option>
                <option value="stark">stark</option>
                <option value="sehr stark">sehr stark</option>
            </select>

            <label>Komfort:</label>
            <select name="komfort" required>
                <option value="unbequem">unbequem</option>
                <option value="so und so">so und so</option>
                <option value="bequem">bequem</option>
            </select>

            <label>Parkplatz:</label>
            <select name="parkplatz" required>
                <option value="nicht ausreichend">nicht ausreichend</option>
                <option value="genügend">genügend</option>
                <option value="viele">viele</option>
                <option value="sehr viele">sehr viele</option>
            </select>

            <label><input type="checkbox" name="anfaengerfreundlich"> Anfängerfreundlich</label><br>
            <label><input type="checkbox" name="regensicher"> Regensicher</label><br>
            <label><input type="checkbox" name="familienfreundlich"> Familienfreundlich</label><br>

            <h3>Sektor</h3>
            <label>Sektorname:</label>
            <input type="text" name="sektor_name" required>

            <label>Koordinaten:</label>
            <input type="text" name="sektor_koordinaten" required>

            <h3>Route</h3>
            <label>Routenname:</label>
            <input type="text" name="routen_name" required>

            <label>Schwierigkeit:</label>
            <input type="text" name="schwierigkeit" required>

            <label>Routenlänge (m):</label>
            <input name="routenlaenge" type="number" step="0.1" required>

            <label>Beschreibung:</label>
            <input name="routen_beschreibung">

            <button type="submit" name="submit">Route hinzufügen</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $pdo = new PDO("mysql:host=localhost;dbname=climbingroutes_db", "root", "maRJN6D12bWB");

            // Gebietsdaten
            $gebiets_name = $_POST['gebiets_name'];
            // Untergebietsdaten
            $untergebiets_name = $_POST['untergebiets_name'];
            $park_koordinaten = $_POST['park_koordinaten'];
            $fels_koordinaten = $_POST['fels_koordinaten'];
            $hoehenmeter = $_POST['hoehenmeter'];
            $wand_ausrichtung = $_POST['wand_ausrichtung'];
            $schoenheit = $_POST['schoenheit'];
            $sicherheit_bewertung = $_POST['sicherheit_bewertung'];
            $besucherandrang = $_POST['besucherandrang'];
            $komfort = $_POST['komfort'];
            $parkplatz = $_POST['parkplatz'];
            $anfaengerfreundlich = isset($_POST['anfaengerfreundlich']) ? 1 : 0;
            $regensicher = isset($_POST['regensicher']) ? 1 : 0;
            $familienfreundlich = isset($_POST['familienfreundlich']) ? 1 : 0;
            // Sektordaten
            $sektor_name = $_POST['sektor_name'];
            $sektor_koordinaten = $_POST['sektor_koordinaten'];
            // Routendaten
            $routen_name = $_POST['routen_name'];
            $schwierigkeit = $_POST['schwierigkeit'];
            $routenlaenge = $_POST['routenlaenge'];
            $routen_beschreibung = $_POST['routen_beschreibung'];

            $pdo -> exec("INSERT INTO Gebiete (gebiets_name) VALUES ('$gebiets_name')");
            $gebiets_id = $pdo -> lastInsertId();

            $pdo -> exec("INSERT INTO UnterGebiete (untergebiets_name, gebiets_referenz, park_koordinaten, fels_koordinaten, hoehenmeter, wand_ausrichtung, schoenheit, sicherheit_bewertung, besucherandrang, komfort, parkplatz, anfaengerfreundlich, regensicher, familienfreundlich) 
            VALUES ('$untergebiets_name', '$gebiets_id', '$park_koordinaten', '$fels_koordinaten', '$hoehenmeter', '$wand_ausrichtung', '$schoenheit', '$sicherheit_bewertung', '$besucherandrang', '$komfort', '$parkplatz', '$anfaengerfreundlich', '$regensicher', '$familienfreundlich')");
            $untergebiets_id = $pdo -> lastInsertId();

            $pdo -> exec("INSERT INTO Sektoren (sektor_name, koordinaten, untergebiets_id) 
            VALUES ('$sektor_name', '$sektor_koordinaten', '$untergebiets_id')");
            $sektor_id = $pdo ->lastInsertId();

            $pdo -> exec("INSERT INTO Routen (routen_name, schwierigkeit, routenlaenge, routen_beschreibung, sektor_id) 
            VALUES ('$routen_name', '$schwierigkeit', '$routenlaenge', '$routen_beschreibung', '$sektor_id')");

            echo "<p>Route erfolgreich hinzugefügt!</p>";
        }
        ?>


    </div>
</body>

</html>
