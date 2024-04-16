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

// Kui vorm on esitatud, salvestame hinnangu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nimi = $_POST["nimi"];
    $kommentaar = $_POST["kommentaar"];
    $hinnang = $_POST["hinnang"];
    $restorani_id = $_POST["restorani_id"];
    
    // Lisame hinnangu andmebaasi
    $sql = "INSERT INTO hinnangud (nimi, kommentaar, hinnang, restorani_id) VALUES ('$nimi', '$kommentaar', $hinnang, $restorani_id)";
    if ($conn->query($sql) === TRUE) {
        // Suuname tagasi avalehele või kuhu iganes soovid
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
    <title>Hinnangu andmine</title>
</head>
<body>
    <h1>Anna hinnang restoranile</h1>

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
