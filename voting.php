<?php
include_once("actions/nsession.php");
?>

<html>

<head>

    <title>SupremeVoting - Abstimmen</title>
    <meta charset="utf-8">

    <script>
        function onload() {
            const params = new URLSearchParams(window.location.search);
            const msg = document.getElementById("msg");

            msg.style = "color: red";

            switch (params.get("msg")) {
                case "login":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Willkommen zurück, <?php echo $_SESSION['name'] ?>!";
                    break;
                case "created":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Abstimmung erfolgreich erstellt!";
                    break;
                case "voted":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Erfolgreich abgestimmt!";
                    break;
                case "no_logout":
                    msg.innerText = "Abmeldung konnte nicht erfolgen!";
                    break;
                case "inv_vote":
                    msg.innerText = "Ungültige Abstimmung!";
                    break;
                case "no_choice":
                    msg.innerText = "Sie müssen mindestens eine Auswahlmöglichkeit auswählen!";
                    break;
                case "db_con_err":
                    msg.innerText = "Verbindung zur Datenbank fehlgeschlagen!";
                    break;
                case "db_quy_err":
                    msg.innerText = "Änderung in der Datenbank fehlgeschlagen!";
                    break;
                case "already_voted":
                    msg.innerText = "Sie haben bei dieser Abstimmung bereits abgestimmt!";
                    break;
                case "inv_pw":
                    msg.innerText = "Passwort falsch!";
                    break;
                case "no_pw":
                    msg.innerText = "Feld 'Administrator Passwort' nicht ausgefüllt";
                    break;
                case "deleted":
                    msg.style = "color: mediumseagreen";
                    msg.innerText = "Erfolgreich gelöscht!";
                    break;
            }
        }
    </script>

</head>

<body onload="onload()" style="font-family:Arial, Helvetica, sans-serif">

    <h1>SupremeVoting</h1>

    <?php
    include("actions/load_votes.php");
    ?>

    <h3 id="msg"><br></h3>

    <a href="create_vote.php">Abstimmung erstellen</a><br>

    <a href="actions/logout.php">Abmelden</a>

</body>

</html>