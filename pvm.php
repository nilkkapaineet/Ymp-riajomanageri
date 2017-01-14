<?php
 /* This is a multi line comment
 
 Mitäs jos etapin numeron pitäisi yllä sillä tavoin, että
 se haettaisiin aina tiedostosta require() käskyllä ja etappi määräytyisikin päivämäärän ja 
 ajankohdan mukaan.
 Samalla skripti voisi pitää huolen siitä, ettei muutoksia voisi tehdä etapin aikana eikä ennen pisteytystä.

Näin se toimii:
 
$dt = new DateTime();
echo $dt->format('Y-m-d H:i:s');
$date = strtotime($dt->format('Y-m-d H:i:s'));
echo date('H', $date);
echo date('i', $date);
echo date('d', $date);

 Ongelmanahan edelleen on, että pisteytys pitäisi käydä tekemässä heti etapin jälkeen.
 
       yet another line of comment */

$dt = new DateTime();
$dt->format('Y-m-d H:i:s');
$date = strtotime($dt->format('Y-m-d H:i:s'));
$H = date('H', $date);       
$i = date('i', $date);
$s = date('s', $date);
$Y = date('Y', $date);
$m = date('m', $date);
$d = date('d', $date);

# etapin numero sitten valtavalla switch hässäkällä

switch ($d) {
    case "12":
        echo "etappi 1<br>";
        break;
    case "13":
        echo "etappi 2<br>";
        break;
    case "14":
        echo "etappi 3<br>";
        break;
    case "15":
        echo "etappi 4<br>";
        break;
    case "16":
        echo "etappi 5<br>";
        break;
    case "17":
        echo "etappi 6<br>";
        break;    
    default:
        echo "Jokin muu etappi<br>";
}
       
?>
