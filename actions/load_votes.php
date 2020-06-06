<?php

include_once("config/config.php");

date_default_timezone_set("Europe/Vienna");

$votes = mysqli_query($sqlconn, "SELECT * FROM votes");

$num_votes = mysqli_num_rows($votes);

if ($num_votes > 0) {

    for ($i = 0; $i < $num_votes; $i++) {
        $current = mysqli_fetch_assoc($votes);
        $choices = unserialize(utf8_decode($current['choices']));
        $score = unserialize($current['score']);
        $limit = new DateTime($current['time_limit']);

        if ($limit > new DateTime()) {

            echo "<form action='vote.php' method='post' enctype='multipart/form-data'>";
            echo utf8_decode("<h2 id='vote$i'>{$current['name']} <input type='submit' value='x' name='del'></h2>");

            $k = 0;
            foreach ($choices as $choice) {
                echo "<b>$choice</b>";
                echo "<br>";
                if (file_exists("votes/{$current['id']}/$k.jpg")) {
                    echo "<img src='../votes/{$current['id']}/$k.jpg'>";
                } else if (file_exists("votes/{$current['id']}/$k.jpeg")) {
                    echo "<img src='../votes/{$current['id']}/$k.jpeg'>";
                } else if (file_exists("votes/{$current['id']}/$k.png")) {
                    echo "<img src='../votes/{$current['id']}/$k.png'>";
                }

                if ($current['multiple']) {
                    echo utf8_encode("<input type='checkbox' name='choice$k'>");
                } else {
                    echo utf8_encode("<input type='radio' name='choice' value='$k'>");
                }
                echo "<br>{$score[$k]} mal gewählt";
                echo "<br><br>";
                $k++;
            }

            echo "<br>";
            echo "<input type='submit' value='Abstimmen'>";
            echo "<input type='hidden' name='id' value='{$current['id']}'>";
            echo "<input type='hidden' name='multiple' value='{$current['multiple']}'>";
            echo "</form>";
            echo "<br><br>";
        } else {
            echo "<form action='vote.php' method='post' enctype='multipart/form-data'>";
            echo utf8_decode("<h2 id='vote$i' style='color:mediumseagreen'>{$current['name']} (abgeschlossen) <input type='submit' value='x' name='del'></h2>");

            $k = 0;
            foreach ($choices as $choice) {
                echo "<b>$choice</b>";
                echo "<br>";
                if (file_exists("votes/{$current['id']}/$k.jpg")) {
                    echo "<img src='../votes/{$current['id']}/$k.jpg'>";
                } else if (file_exists("votes/{$current['id']}/$k.jpeg")) {
                    echo "<img src='../votes/{$current['id']}/$k.jpeg'>";
                } else if (file_exists("votes/{$current['id']}/$k.png")) {
                    echo "<img src='../votes/{$current['id']}/$k.png'>";
                }

                echo "<br>{$score[$k]} mal gewählt";
                echo "<br><br>";
                $k++;
            }

            echo "<input type='hidden' name='id' value='{$current['id']}'>";
            echo "<input type='hidden' name='multiple' value='{$current['multiple']}'>";
            echo "</form>";
            echo "<br><br>";
        }
    }
} else {
    echo "<h2>Keine ausstehenden Abstimmungen</h2>";
}
