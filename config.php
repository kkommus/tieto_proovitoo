<?php
                // Andmebaasi ühendus
                $server = "localhost";
                $username = "keiti"; // asenda oma tegeliku kasutajanimega
                $password = "sh2mp00n"; // asenda oma tegeliku parooliga
                $database = "restoranid"; // asenda oma tegeliku andmebaasi nimega

                // Loome andmebaasi ühenduse
                $conn = new mysqli($server, $username, $password, $database);

                // Kontrollime ühendust
                if ($conn->connect_error) {
                    die("Ühendus ebaõnnestus: " . $conn->connect_error);
                }
?>