<?php
include("config.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $paring = "SELECT * FROM restoranid WHERE id = ?";
    $stmt = $yhendus->prepare($paring);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $nimi = $row['nimi'];
    $asukoht = $row['asukoht'];
    $tyyp = $row['tyyp'];


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Muuda restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Muuda restorani</h1>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="mb-3">
            <label for="nimi" class="form-label">Nimi</label>
            <input type="text" class="form-control" id="nimi" name="nimi" value="<?php echo $nimi; ?>">
        </div>

        <div class="mb-3">
            <label for="aadress" class="form-label">Asukoht</label>
            <input type="text" class="form-control" id="asukoht" name="asukoht" value="<?php echo $asukoht; ?>">
        </div>

        <div class="mb-3">
            <label for="tyyp" class="form-label">Söögikoha tüüp</label>
            <select class="form-control" id="tyyp" name="tyyp">
                <option value="restoran" <?php if($tyyp == "restoran") echo "selected"; ?>>Restoran</option>
                <option value="kohvik" <?php if($tyyp == "kohvik") echo "selected"; ?>>Kohvik</option>
                <option value="baari" <?php if($tyyp == "baari") echo "selected"; ?>>Baar</option>
                <option value="pubi" <?php if($tyyp == "pubi") echo "selected"; ?>>Pubi</option>
<option value="kiirtoidukoht" <?php if($tyyp == "kiirtoidukoht") echo "selected"; ?>>Kiirtoidukoht</option>
<option value="pizzeria" <?php if($tyyp == "pizzeria") echo "selected"; ?>>Pizzeria</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvesta</button>
        <a href="admin.php" class="btn btn-secondary">Tagasi</a>
    </form>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>