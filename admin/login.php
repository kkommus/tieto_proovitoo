<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Sisselogimine</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kasutaja = $_POST['kasutaja'];
    $parool = $_POST['parool'];

    if ($kasutaja == "admin" && $parool == "admin123") {
        $_SESSION['login'] = "1";
        header("Location: admin.php");
        exit();
    } else {
        echo "Proovi uuesti";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Sisselogimine</h2>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="kasutaja">Kasutajanimi:</label>
                            <input type="text" name="kasutaja" id="kasutaja" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="parool">Parool:</label>
                            <input type="password" name="parool" id="parool" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Logi sisse" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>