<?php
include("config.php");

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $nimi = $_POST['nimi'];
    $asukoht = $_POST['asukoht'];
    $tyyp = $_POST['tyyp'];

    $paring = "UPDATE restoranid SET nimi = ?, asukoht = ?, tyyp = ? WHERE id = ?";
    $stmt = $yhendus->prepare($paring);
    $stmt->bind_param("sssi", $nimi, $asukoht, $tyyp, $id);

    if($stmt->execute()) {
        header("Location: muuda.php?id=$id");
    } else {
        echo "Viga restorani uuendamisel: " . $stmt->error;
    }
}
?>