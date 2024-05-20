<?php
session_start();

if(!isset($_SESSION['login'])){

    header("Location: login.php");
    die("Vale koht");
}

//print_r($_SESSION['login'] );
?>
<a href="logout.php">Logi välja</a>

<?php include("config.php"); ?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
<link rel="shortcut icon" href="favicon.png" type="image/png">
<title>Hinda söögikohti</title>
</head>
<body>

<div class="text-center mt-5">
        <h1>Valige asutus, mida hinnata</h1>
    </div>

    <?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$start = ($page - 1) * $limit;

$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $paring = "SELECT * FROM restoranid WHERE nimi LIKE '%$search%' OR asukoht LIKE '%$search%' ORDER BY nimi ASC LIMIT $start, $limit";
} else {
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nimi';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $paring = "SELECT * FROM restoranid ORDER BY $sort $order LIMIT $start, $limit";
}

$valjund = mysqli_query($yhendus, $paring);

// Lehekülgede navigatsioon
$paring_count = "SELECT COUNT(id) AS total FROM restoranid";
$valjund_count = mysqli_query($yhendus, $paring_count);
$row = mysqli_fetch_assoc($valjund_count);
$total_pages = ceil($row['total'] / $limit);
?>


<div class="container mt-5">


    <form action="" method="get" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Otsi">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Otsi</button>
            </div>
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
            <?php if (mysqli_num_rows($valjund) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($valjund)): ?>
                    <tr>
                        <td><a href='adminhinda.php?id=<?php echo $row['id']; ?>'><?php echo $row['nimi']; ?></a></td>
                        <td><?php echo $row['asukoht']; ?></td>
                        <td><?php echo $row['hinnang']; ?></td>
                        <td><?php echo $row['kordade_arv']; ?></td>
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
        <?php if ($page > 1): ?>
            <a href='?page=<?php echo ($page - 1); ?>' class="btn btn-primary">Eelmised</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href='?page=<?php echo ($page + 1); ?>' class="btn btn-primary ml-auto">Järgmised</a>
        <?php endif; ?>
    </div>

</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>