<?php
// Andmebaasi ühendus
$server = "localhost";
$username = "keiti"; // asenda oma tegeliku kasutajanimega
$password = "sh2mp00n"; // asenda oma tegeliku parooliga
$database = "restoranid"; // asenda oma tegeliku andmebaasi nimega

// Loome andmebaasi ühenduse
$conn = new mysqli($server, $username, $password, $database);

// Kontrollime ühendust
if ($conn->connect_error) {
    die("Ühendus ebaõnnestus: " . $conn->connect_error);
}

// Funktsioon, mis tagastab hinnangute keskmise
function keskmine_hinne($conn, $restorani_id) {
    $sql = "SELECT AVG(hinnang) AS keskmine FROM hinnangud WHERE restorani_id = $restorani_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return round($row["keskmine"], 1);
    } else {
        return "-";
    }
}

// Kui vorm on esitatud, salvestame hinnangu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nimi = $_POST["nimi"];
    $kommentaar = $_POST["kommentaar"];
    $hinnang = $_POST["hinnang"];
    $restorani_id = $_POST["restorani_id"];
    
    // Lisame hinnangu andmebaasi
    $sql = "INSERT INTO hinnangud (nimi, kommentaar, hinnang, restorani_id) VALUES ('$nimi', '$kommentaar', $hinnang, $restorani_id)";
    if ($conn->query($sql) === TRUE) {
        // Suuname tagasi avalehele
        header("Location: index.php");
        exit();
    } else {
        echo "Viga andmete salvestamisel: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Söögikohtade hindamine</title>
    <style>
        /* Lisa oma CSS siia */
    </style>
</head>
<body>
    <h1>Söögikohtade hindamine</h1>
    <h2>Avalikud hinnangud</h2>
    <table>
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Asukoht</th>
                <th>Keskmine hinne</th>
                <th>Hinnatud kordi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Küsime andmeid andmebaasist ja kuvame need tabelis
            $sql = "SELECT * FROM restoranid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $keskmine_hinne = keskmine_hinne($conn, $row["id"]);
                    echo "<tr>";
                    echo "<td>" . $row["nimi"] . "</td>";
                    echo "<td>" . $row["asukoht"] . "</td>";
                    echo "<td>" . ($keskmine_hinne != "-" ? $keskmine_hinne : "-") . "</td>";
                    echo "<td>" . $row["hinnangute_arv"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Andmed puuduvad</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Sisesta oma hinnang</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nimi">Sinu nimi:</label>
        <input type="text" id="nimi" name="nimi" required><br><br>
        <label for="kommentaar">Kommentaar:</label><br>
        <textarea id="kommentaar" name="kommentaar" required></textarea><br><br>
        <label for="hinnang">Hinnang (1-10):</label>
        <input type="number" id="hinnang" name="hinnang" min="1" max="10" required><br><br>
        <label for="restorani_id">Vali restoran:</label>
        <select id="restorani_id" name="restorani_id">
            <?php
            // Küsime andmeid andmebaasist ja kuvame need rippmenüüs
            $sql = "SELECT * FROM restoranid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["nimi"] . "</option>";
                }
            } else {
                echo "<option value=''>Andmed puuduvad</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" value="Saada hinnang">
    </form>

    <?php
    // Sulgeme andmebaasi ühenduse
    $conn->close();
    ?>
</body>
</html>
