<?php
include("config.php");

$nimi = '';
$asukoht = '';
$id = 0;

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $paring = "SELECT * FROM restoranid WHERE id = ?";
    $stmt = $yhendus->prepare($paring);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nimi = $row['nimi'];
        $asukoht = $row['asukoht'];
    } else {
        // ID-le vastav restoran ei leitud
        echo "Restoran andmetega ID-ga $id ei leitud.";
        exit();
    }
} else {
    // ID puudub URL-is või ei ole õige
    echo "Restoran ID-d ei ole määratud või on see vigane.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Muuda restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Muuda restorani</h1>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <div class="mb-3">
            <label for="nimi" class="form-label">Nimi</label>
            <input type="text" class="form-control" id="nimi" name="nimi" value="<?php echo htmlspecialchars($nimi); ?>">
        </div>

        <div class="mb-3">
            <label for="asukoht" class="form-label">Asukoht</label>
            <input type="text" class="form-control" id="asukoht" name="asukoht" value="<?php echo htmlspecialchars($asukoht); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Salvesta</button>
        <a href="admin.php" class="btn btn-secondary">Tagasi</a>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
</body>
</html>
