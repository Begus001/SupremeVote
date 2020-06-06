<?php
include_once("actions/session.php");
?>

<html>

<head>

    <title>SupremeVoting - Login</title>
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
                case "inv_user":
                    msg.innerText = "Benutzer existiert nicht!";
                    break;
                case "inv_pw":
                    msg.innerText = "Passwort falsch!";
                    break;
                case "no_login":
                    msg.innerText = "Sie sind nicht angemeldet!";
                    break;
                case "inv_login":
                    msg.innerText = "Inkorrekte Anmeldedaten!";
                    break;
                case "db_con_err":
                    msg.innerText = "Verbindung zur Datenbank fehlgeschlagen!";
                    break;
                case "db_quy_err":
                    msg.innerText = "Änderung in der Datenbank fehlgeschalgen!";
                    break;
                case "logout":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Erfolgreich abgemeldet!";
                    break;
            }
        }
    </script>

</head>

<body onload="onload()" style="font-family:Arial, Helvetica, sans-serif">

    <h1>SupremeVoting Login</h1>

    <form action="actions/login.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name">
        <input type="password" name="pw" placeholder="Passwort">
        <input type="submit" value="Login">
    </form>

    <h3 id="msg"><br></h3>

    <a href="register.php">Registrieren</a>

</body>

</html>