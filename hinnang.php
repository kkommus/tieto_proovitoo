<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hinnangu andmine</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-input {
            display: none;
        }

        .star-label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
        }

        .star-label:hover,
        .star-label:hover ~ .star-label,
        .star-input:checked ~ .star-label {
            color: orange;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                // Ühendame andmebaasiga
include("config.php");

// Kontrollime ühendust
if (!$yhendus) {
    die("Ei saa ühendust andmebaasiga");
}

                // Vaatame, kas restorani ID on määratud $_GET päringuga
                if(isset($_GET['restorani_id'])) {
                    $restorani_id = $_GET['restorani_id'];

                    // Küsime andmebaasist restorani nime vastavalt ID-le
                    $sql = "SELECT nimi FROM restoranid WHERE id = $restorani_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $restorani_nimi = $row["nimi"];
                    } else {
                        $restorani_nimi = "Valitud restoran";
                    }
                } else {
                    $restorani_nimi = "Valitud restoran";
                }

                // Salvestame hinnangu andmed, kui vorm on saatnud
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nimi = $_POST['nimi'];
                    $kommentaar = $_POST['kommentaar'];
                    $hinnang = $_POST['hinnang'];

                    // SQL päringu ettevalmistamine hinnangu salvestamiseks
                    $sql = "INSERT INTO hinnangud (restorani_id, nimi, kommentaar, hinnang) VALUES ($restorani_id, '$nimi', '$kommentaar', $hinnang)";

                    // Päringu käivitamine
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Hinnang edukalt salvestatud</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Viga: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
                ?>

                <h1 class="mb-4">Anna hinnang restoranile: <?php echo htmlspecialchars($restorani_nimi); ?></h1>

                <form method="post" action="">
                    <input type="hidden" name="restorani_id" value="<?php echo htmlspecialchars($restorani_id); ?>">
                    <div class="form-group">
                        <label for="nimi">Sinu nimi:</label>
                        <input type="text" class="form-control" id="nimi" name="nimi" required>
                    </div>
                    <div class="form-group">
                        <label for="kommentaar">Kommentaar:</label>
                        <textarea class="form-control" id="kommentaar" name="kommentaar" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hinnang">Hinnang (10-1):</label><br>
                        <?php for ($i = 10; $i >= 1; $i--): ?>
                            <input type="radio" id="hinnang_<?php echo $i; ?>" class="star-input" name="hinnang" value="<?php echo $i; ?>" required>
                            <label for="hinnang_<?php echo $i; ?>" class="star-label">&#9733;</label>
                        <?php endfor; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Saada hinnang</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Sulgeme andmebaasi ühenduse
    $conn->close();
    ?>
    <script>
        // Valige kõik tähed
        var starElements = document.querySelectorAll('.star-label');

        // Lisage igale tähele kuulaja
        for (var i = 0; i < starElements.length; i++) {
            starElements[i].addEventListener('click', function() {
                // Arvutage valitud tärnide arv
                var selectedStars = Array.from(starElements).indexOf(this) + 1;

                // Muutke see vastupidiseks
                var reversedStars = 11 - selectedStars;

                // Näidake vastupidist tärnide arvu
                console.log('Valitud tärnide arv (vastupidine):', reversedStars);
            });
        }
    </script>
</body>
</html>
