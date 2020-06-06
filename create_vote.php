<?php
include_once("actions/nsession.php");
include_once("config/config.php");
?>

<html>

<head>

    <title>SupremeVoting - Abstimmung erstellen</title>
    <meta charset="utf-8">

    <script>
        var nextField = 1;

        function onload() {
            const params = new URLSearchParams(window.location.search);
            const msg = document.getElementById("msg");

            msg.style = "color: red";

            switch (params.get("msg")) {
                case "no_name":
                    msg.innerText = "Feld 'Name' nicht ausgefüllt!";
                    break;
                case "no_pw":
                    msg.innerText = "Feld 'Administrator Passwort' nicht ausgefüllt";
                    break;
                case "inv_pw":
                    msg.innerText = "Passwort falsch!";
                    break;
                case "inv_vote":
                    msg.innerText = "Jede Auswahlmöglichkeit muss mindestens einen Namen oder ein Bild beinhalten!";
                    break;
                case "big_img":
                    msg.innerText = "Eine der Dateien übersteigt die maximale Dateigröße von 8 MiB!";
                    break;
                case "inv_file":
                    msg.innerText = "Sie dürfen nur PNG- und JPG-Dateien hochladen!";
                    break;
                case "db_con_err":
                    msg.innerText = "Verbindung zur Datenbank fehlgeschlagen!";
                    break;
                case "db_quy_err":
                    msg.innerText = "Änderung in der Datenbank fehlgeschlagen!";
                    break;
                case "upload_err":
                    msg.innerText = "Eine der Dateien konnte nicht hochgeladen werden!";
                    break;
                case "no_limit":
                    msg.innerText = "Feld 'Auswertungsdatum' nicht ausgefüllt!";
                    break;
                case "inv_limit":
                    msg.innerText = "Das Auswertungsdatum darf das aktuelle Datum nicht unterschreiten!";
            }
        }

        function add_choice() {
            var vote = document.getElementById("vote");
            var plus = document.getElementById("add");
            var field = document.createElement("input");
            var file = document.createElement("input");
            var br = document.createElement("br");

            field.setAttribute("type", "text");
            field.setAttribute("name", "choice" + nextField);
            field.setAttribute("placeholder", "Auswahlmöglichkeit " + (nextField + 1));
            field.style.marginRight = "4px";

            file.setAttribute("type", "file");
            file.setAttribute("name", "img" + nextField);

            vote.insertBefore(field, plus);
            vote.insertBefore(file, plus);
            vote.insertBefore(br, plus);
            nextField++;
        }
    </script>

    <style>
        #add:hover {
            cursor: pointer;
        }
    </style>

</head>

<body onload="onload()" style="font-family:Arial, Helvetica, sans-serif">

    <h1>SupremeVoting - Abstimmung erstellen</h1>

    <form id="vote" method="post" action="actions/create_vote.php" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name"><br><br>
        <input type="text" name="choice0" placeholder="Auswahlmöglichkeit 1">
        <input type="file" name="img0"><br>
        <span id="add" style="font-size:24px" onclick="add_choice()">+</span><br><br>
        <input type="checkbox" name="multiple">
        <label for="multiple">Mehrere Auswahlmöglichkeiten zulassen</label><br><br>
        <label for="limit">Auswertungsdatum (dd-mm-yyyy MM:HH)</label><br>
        <input type="datetime-local" name="limit"><br><br>
        <input type="password" name="pw" placeholder="Administrator Passwort" value="<?php echo (isset($_SESSION['admin']) && $_SESSION['admin']) ? ADMIN_PW : ""; ?>"><br><br>
        <input type="submit" value="Abstimmung erstellen">
    </form>

    <h3 id="msg"><br></h3>

    <a href="voting.php">Abstimmen</a><br>
    <a href="actions/logout.php">Abmelden</a>

</body>

</html>