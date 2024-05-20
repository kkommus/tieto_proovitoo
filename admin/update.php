<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['nimi'], $_POST['asukoht']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
        $nimi = htmlspecialchars(trim($_POST['nimi']));
        $asukoht = htmlspecialchars(trim($_POST['asukoht']));

        if (!empty($nimi) && !empty($asukoht)) {
            $paring = "UPDATE restoranid SET nimi = ?, asukoht = ? WHERE id = ?";
            $stmt = $yhendus->prepare($paring);
            $stmt->bind_param("ssi", $nimi, $asukoht, $id);

            if ($stmt->execute()) {
                // Suunamine admin.php lehele pärast edukat uuendamist
                header("Location: admin.php");
                exit();
            } else {
                echo "Viga restorani uuendamisel: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Palun täitke kõik väljad.";
        }
    } else {
        echo "Vigane ID või puuduvad andmed.";
    }
} else {
    echo "Vale päringumeetod.";
}

$yhendus->close();
?>
