<?php
include_once("actions/session.php");
?>

<html>

<head>

    <title>SupremeVoting - Registrierung</title>
    <meta charset="utf-8">

    <script>
        function onload() {
            const params = new URLSearchParams(window.location.search);
            const msg = document.getElementById("msg");

            msg.style = "color: red";

            switch (params.get('msg')) {
                case "no_name":
                    msg.innerText = "Feld 'Name' nicht ausgefüllt!";
                    break;
                case "no_pw":
                    msg.innerText = "Feld 'Passwort' nicht ausgefüllt!";
                    break;
                case "no_cpw":
                    msg.innerText = "Feld 'Passwort bestätigen' nicht ausgefüllt!";
                    break;
                case "pw_mismatch":
                    msg.innerText = "Passwortbestätigung stimmt nicht mit Passwort überein!";
                    break;
                case "name_taken":
                    msg.innerText = "Nutzername bereits vergeben!";
                    break;
                case "db_con_err":
                    msg.innerText = "Verbindung zur Datenbank fehlgeschlagen!";
                    break;
                case "db_quy_err":
                    msg.innerText = "Änderung in der Datenbank fehlgeschlagen!";
                    break;
                case "registered":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Registrierung erfolgreich! Sie können sich nun einloggen.";
                    break;
            }
        }
    </script>

</head>

<body onload="onload()" style="font-family:Arial, Helvetica, sans-serif">

    <h1>SupremeVoting Registrierung</h1>

    <form action="actions/register.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name">
        <input type="password" name="pw" placeholder="Passwort">
        <input type="password" name="cpw" placeholder="Passwort bestätigen">
        <input type="submit" name="submit" value="Registrieren">
    </form>

    <h3 id="msg"><br></h3>

    <a href="index.php">Login</a>

</body>

</html>