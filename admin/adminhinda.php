<?php include("config.php"); ?>

<?php

$errors = [];
$nimi = $hinne = $kommentaar = '';

if (isset($_GET['id'])) {
    $restorani_id = $_GET['id'];
} elseif (isset($_POST['restorani_id'])) {
    $restorani_id = $_POST['restorani_id'];
} else {
    die("Restorani ID puudub. Suunatakse tagasi.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $paring = "SELECT * FROM restoranid WHERE id = ?";
    $stmt = $yhendus->prepare($paring);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $restorani_nimi = $row['nimi'];
} else {
    $restorani_nimi = "Restorani nime ei leitud";
}

// Hinnangute päring
$paring = "SELECT * FROM hinnangud WHERE restorani_id = ?";
$stmt = $yhendus->prepare($paring);
$stmt->bind_param('i', $restorani_id);
$stmt->execute();
$tulemus = $stmt->get_result();

// Hinnangu lisamine
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nimi'], $_POST['hinnang'], $_POST['kommentaar'])) {
    $nimi = $_POST['nimi'];
    $hinnang = $_POST['hinnang'];
    $kommentaar = $_POST['kommentaar'];

    if (empty($nimi) || empty($hinnang) || empty($kommentaar)) {
        $errors[] = 'Kõik väljad on kohustuslikud!';
    }

    if (empty($errors)) {
        $paring = "INSERT INTO hinnangud (restorani_id, nimi, kommentaar, hinnang) VALUES (?, ?, ?, ?)";
        $stmt = $yhendus->prepare($paring);
        $stmt->bind_param('isss', $restorani_id, $nimi, $kommentaar, $hinnang);

        if ($stmt->execute()) {
            $paring = "UPDATE restoranid
                   SET hinnang = (SELECT SUM(hinnang) FROM hinnangud WHERE restorani_id = ?) /
                                         (SELECT COUNT(*) FROM hinnangud WHERE restorani_id = ?),
                       kordade_arv = (SELECT COUNT(*) FROM hinnangud WHERE restorani_id = ?)
                   WHERE id = ?";
        $stmt = $yhendus->prepare($paring);
        $stmt->bind_param('iiii', $restorani_id, $restorani_id, $restorani_id, $restorani_id);
        $stmt->execute();

        header("Location: adminhinda.php?msg=true&id=$restorani_id");
        exit();
        } else {
            echo "Viga: " . $stmt->error;
        }
     }
}


// Hinnangu kustutamine
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["del"]) && isset($_POST["id"])) {
    $id = $_POST["id"];
    $paring = "DELETE FROM hinnangud WHERE id=?";
    $stmt = $yhendus->prepare($paring);

    if (!$stmt) {
        die("Viga päringu valmistamisel: " . $yhendus->error);
    }

    // Sidumine
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {

            // Uuendame restorani keskmist hinda ja hindajate arvu
            $paring = "UPDATE restoranid
                       SET hinnang = (SELECT SUM(hinnang) FROM hinnangud WHERE restorani_id = ?) /
                                             (SELECT COUNT(*) FROM hinnangud WHERE restorani_id = ?),
                           kordade_arv = (SELECT COUNT(*) FROM hinnangud WHERE restorani_id = ?)
                       WHERE id = ?";
            $stmt = $yhendus->prepare($paring);
            $stmt->bind_param('iiii', $restorani_id, $restorani_id, $restorani_id, $restorani_id);
            $stmt->execute();

            header("Location: adminhinda.php?msg=true&id=$restorani_id");
            exit();
     } else {
            header("Location: admihinda.php?msg=false");
            exit();
     }

}




        // Teeme uue päringu hinnangute kuvamiseks
        $paring = "SELECT * FROM hinnangud WHERE restorani_id = ?";
        $stmt = $yhendus->prepare($paring);
        $stmt->bind_param('i', $restorani_id);
        $stmt->execute();
        $tulemus = $stmt->get_result();




?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Söögikoha hindamine</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="text-center mt-5">
        <h1>Hinda restorani: <?php echo $restorani_nimi; ?></h1>
    </div>

<form action="" method="post">
    <div class="container mt-5">


        <table class="table table-bordered">
            <tr>
                <td>Nimi:</td>
                <td><input type="text" name="nimi" value="<?php echo $nimi; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Kommentaar:</td>
                <td><textarea name="kommentaar" class="form-control"><?php echo $kommentaar; ?></textarea></td>
            </tr>
            <tr>
                <td>Hinnang:</td>
                <td>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "<input type='radio' name='hinnang' value='$i'>$i ";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Hinda" class="btn btn-primary"></td>
            </tr>
        </table>
    </div>
</form>


<?php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
 <h2 class="text-center">Teiste hinnangud:</h2>
 <div class="container mt-5">
    <?php if ($tulemus->num_rows > 0): ?>
        <?php while ($row = $tulemus->fetch_assoc()): ?>
            <div class="row">
                <div class="col-md-2">
                    <strong>ID:</strong> <?php echo $row['id']; ?>
                </div>

                <div class="col-md-4">
                    <strong>Nimi:</strong> <?php echo $row['nimi']; ?><br>
                    <strong>Hinnang:</strong> <?php echo $row['hinnang']; ?>
                </div>
                <div class="col-md-4">
                    <strong>Kommentaar:</strong><br>
                    <?php echo $row['kommentaar']; ?>
                </div>
                <div class="col-md-2">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="restorani_id" value="<?php echo $restorani_id; ?>">
                        <input type="submit" name="del"value="Kustuta" class="btn btn-danger">
                    </form>
                </div>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php endif; ?>
</div>





<div class="ml-5">
        <a href="admin.php" class="btn btn-primary">Tagasi avalehele</a>
    </div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>