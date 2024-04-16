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

// Vaatame, milline leht on praegu avatud
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$per_page = 10;
$start = ($current_page - 1) * $per_page;

// Küsime 10 söögikohta andmebaasist, alustades õigest kohast
$sql = "SELECT * FROM restoranid LIMIT $start, $per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Söögikohtade hindamine</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th {
            width: 33.33%; /* Jagame võrdselt kolme veeru vahel */
            position: sticky;
            top: 0;
        }
        th:first-child, td:first-child {
            left: 0;
            position: sticky;
        }
        th:nth-child(2), td:nth-child(2) {
            left: 33.33%; /* Teine veerg hakkab kolmandiku laiusest alates */
        }
        th:nth-child(3), td:nth-child(3) {
            left: 66.66%; /* Kolmas veerg hakkab kahe kolmandiku laiusest alates */
        }
        .pagination {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1 class="mt-5 mb-4 text-center">Söögikohtade hindamine</h1>
    
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nimi</th>
                <th>Kommentaar</th>
                <th>Hinnang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick='lisaHinnang(" . $row["id"] . ")'>";
                    echo "<td>" . $row["nimi"] . "</td>";
                    echo "<td>" . $row["kommentaar"] . "</td>";
                    echo "<td>" . $row["hinnang"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Andmed puuduvad</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination d-flex justify-content-end">
    <?php if ($current_page > 1): ?>
        <a href="?page=<?php echo $current_page - 1; ?>" class="btn btn-primary">Eelmised</a>
    <?php endif; ?>
    <?php if ($result->num_rows == $per_page): ?>
        <a href="?page=<?php echo $current_page + 1; ?>" class="btn btn-primary">Järgmised</a>
    <?php endif; ?>
</div>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript funktsioon hinnangu lisamiseks
        function lisaHinnang(restorani_id) {
            window.location.href = "hinnang.php?restorani_id=" + restorani_id;
        }
    </script>
</body>
</html>

<?php
// Sulgeme andmebaasi ühenduse
$conn->close();
?>
