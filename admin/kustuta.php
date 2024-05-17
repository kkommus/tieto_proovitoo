<?php
include("config.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kustutamise päring
    $paring = "DELETE FROM restoranid WHERE id = ?";
    $stmt = $yhendus->prepare($paring);
    $stmt->bind_param('i', $id);

    if($stmt->execute()) {
        // Teavitame kasutajat, et restoran on kustutatud
        echo "<script>alert('Restoran on edukalt kustutatud!');</script>";
        header("Location: admin.php");
        exit();
    } else {
        echo "Viga kustutamisel: " . $stmt->error;
    }
} else {
    header("Location: admin.php");
    exit();
}
?>