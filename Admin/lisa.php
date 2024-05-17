<?php
include("config.php");

$errors = [];
$nimi = $asukoht = $tyyp = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nimi = $_POST['nimi'];
    $asukoht = $_POST['asukoht'];
    $tyyp = $_POST['tyyp'];

    if (empty($nimi) || empty($aadress) || empty($tyyp)) {
        $errors[] = 'Kõik väljad on kohustuslikud!';
    }

    if (empty($errors)) {
        $paring = "INSERT INTO restoranid (nimi, asukoht, tyyp) VALUES (?, ?, ?)";
        $stmt = $yhendus->prepare($paring);
        $stmt->bind_param('sss', $nimi, $asukoht, $tyyp);

        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Viga salvestamisel: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Lisa restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Lisa restoran</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
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
                <option value="restoran">Restoran</option>
                <option value="kohvik">Kohvik</option>
                <option value="baari">Baar</option>
                <option value="pubi">Pubi</option>
                <option value="kiirtoidukoht">Kiirtoidukoht</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvesta</button>
        <a href="admin.php" class="btn btn-secondary">Tagasi</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>