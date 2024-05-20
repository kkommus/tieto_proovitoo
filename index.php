<?php
// Ühendame andmebaasiga
include("config.php");

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
$sql = "SELECT r.*, AVG(h.hinnang) AS keskmine_hinnang, COUNT(h.id) AS hinnangute_arv 
        FROM restoranid r 
        LEFT JOIN hinnangud h ON r.id = h.restorani_id 
        GROUP BY r.id 
        LIMIT $start, $per_page";
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
        /* Tabeli ja otsingu stiilid */
        .container {
            margin-top: 20px;
        }

        .table-container {
            width: 80%;
            margin: 0 auto;
        }

        .pagination {
            display: flex;
            justify-content: center; /* Tsentreerime nupud lehekülje suhtes */
            margin-top: 20px;
        }

        .search-container {
            width: 80%;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4 text-center">Söögikohtade hindamine</h1>

        <div class="search-container">
            <form method="GET" action="hinnang.php">
                <div class="form-group">
                    <label for="search">Otsi restorani:</label>
                    <input type="text" class="form-control search-input" id="search" name="restorani_nimi" placeholder="Sisesta restorani nimi">
                </div>
                <button type="submit" class="btn btn-primary">Otsi</button>
            </form>
        </div>

        <div class="table-container">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Nimi</th>
                        <th>Asukoht</th>
                        <th>Keskmine hinne</th>
                        <th>Hinnangud (korda)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["nimi"] . "</td>";
                            echo "<td>" . $row["asukoht"] . "</td>";
                            echo "<td>" . number_format($row["keskmine_hinnang"], 1) . "</td>";
                            echo "<td>" . $row["hinnangute_arv"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Andmed puuduvad</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div class="btn-group">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1; ?>" class="btn btn-primary">Eelmised</a>
                <?php endif; ?>
                <?php if ($result->num_rows == $per_page): ?>
                    <a href="?page=<?php echo $current_page + 1; ?>" class="btn btn-primary">Järgmised</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Sulgeme andmebaasi ühenduse
$conn->close();
?>
