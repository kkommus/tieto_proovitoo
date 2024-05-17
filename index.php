<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    die("Vale koht");
}

// Ühendame andmebaasiga
include("config.php");

// Loome andmebaasi ühenduse
$conn = new mysqli($server, $username, $password, $database);

// Kontrollime ühendust
if ($conn->connect_error) {
    die("Ühendus ebaõnnestus: " . $conn->connect_error);
}

// Vaatame, milline leht on praegu avatud
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 10;
$start = ($current_page - 1) * $per_page;

// Otsingufunktsioon
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM restoranid WHERE nimi LIKE '%$search%' OR asukoht LIKE '%$search%' ORDER BY nimi ASC LIMIT $start, $per_page";
} else {
    $sort = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 'nimi';
    $order = isset($_GET['order']) ? $conn->real_escape_string($_GET['order']) : 'ASC';
    $sql = "SELECT * FROM restoranid ORDER BY $sort $order LIMIT $start, $per_page";
}

$result = $conn->query($sql);

// Lehekülgede navigatsioon
$sql_count = "SELECT COUNT(id) AS total FROM restoranid";
$result_count = $conn->query($sql_count);
$row = $result_count->fetch_assoc();
$total_pages = ceil($row['total'] / $per_page);

$conn->close();
?>

<!doctype html>
<html lang="et">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
<link rel="shortcut icon" href="favicon.png" type="image/png">
<title>Hinda söögikohti</title>
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <h1>Valige asutus, mida hinnata</h1>
        <a href="logout.php" class="btn btn-secondary">Logi välja</a>
    </div>

    <form action="" method="get" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Otsi">
            <button class="btn btn-primary" type="submit">Otsi</button>
        </div>
    </form>

    <div class="mb-4">
        <a href="lisa.php" class="btn btn-success">Lisa uus</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><a href="?sort=nimi&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Nimi</a></th>
                <th><a href="?sort=asukoht&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Asukoht</a></th>
                <th><a href="?sort=hinnang&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Keskmine hinne</a></th>
                <th><a href="?sort=kordade_arv&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Hinnatud kordi</a></th>
                <th>Toimingud</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><a href='adminhinda.php?id=<?php echo $row['id']; ?>'><?php echo htmlspecialchars($row['nimi']); ?></a></td>
                        <td><?php echo htmlspecialchars($row['asukoht']); ?></td>
                        <td><?php echo htmlspecialchars($row['hinnang']); ?></td>
                        <td><?php echo htmlspecialchars($row['kordade_arv']); ?></td>
                        <td>
                            <a href='muuda.php?id=<?php echo $row['id']; ?>' class="btn btn-warning">Muuda</a>
                            <a href='kustuta.php?id=<?php echo $row['id']; ?>' class="btn btn-danger" onclick="return confirm('Kas oled kindel, et soovid kustutada?')">Kustuta</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan='5'>Andmed puuduvad</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <?php if ($current_page > 1): ?>
            <a href='?page=<?php echo ($current_page - 1); ?>' class="btn btn-primary">Eelmised</a>
        <?php endif; ?>
        <?php if ($current_page < $total_pages): ?>
            <a href='?page=<?php echo ($current_page + 1); ?>' class="btn btn-primary ml-auto">Järgmised</a>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
