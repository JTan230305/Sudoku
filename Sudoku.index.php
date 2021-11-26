<?php

/* Dit is de index-code waar alle andere code met elkaar zal worden verbonden.
In principe is dit een beginfase voor het eigenlijke project, en het moet nog verwerkt en getest worden./*

// zet de foutmeldingen aan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// zorg dat je de functies kan gebruiken
require "functions.php";

// maak een multidimensionale array van de sudoku
$sudoku = array(
    array(2, 3, 0, 4),
    array(1, 0, 2, 0),
    array(4, 0, 0, 1),
    array(0, 1, 4, 0)
);

// geef alle mogelijke opties aan die in één veld kunnen
$opties = range(1,count($sudoku));

// loop door de sudoku rij voor rij, kolom voor kolom
foreach($sudoku as $y => $rij) {
    foreach($rij as $x => $veld) {
        // als veld de waarde 0 heeft zorg dan dat dit wijzigt in een array met alle opties
        if($veld == 0) {
            $veld = $opties;
        }

        // is het veld een array dan moet je dus nog uitzoeken wat de juiste waarde is.
        // elemineer alle waardes uit de array die al in de rij voorkomen
        if(is_array($veld)) {
            $veld = elimineer_rij($veld, $rij);
        }

        // elemineer alle waardes uit de array die al in de kolom voorkomen
        if(is_array($veld)) {
            $veld = elimineer_kolom($veld, $x, $sudoku);
        }

        // elemineer alle waardes uit de array die al in het blok voorkomen
        if(is_array($veld)) {
            $veld = elimineer_blok($veld, $x, $y, $sudoku);
        }

        // ... dit is de basis, maar niet genoeg om alle sudoku's op te lossen, maak het algoritme hier verder ...

        // plaats de gevonden waarde(s) weer terug in de sudoku
        $sudoku[$y][$x] = $veld;

    }
}


// toon de sudoku
$sudokuprint = $sudoku;
require "display.php";

/* Deze code hieronder zijn de functies die ik gebruik bij het project, oftewel wat je in het programma kunt laten gebeuren met de Sudoku. */

function elimineer_rij($veld, $rij) {
    // haal uit de array $veld alle waardes die al voorkomen in de rij ($rij)
    return clear($veld);
}

function elimineer_kolom($veld, $kolomindex, $sudoku) {
    // haal uit de array $veld alle waardes die al voorkomen in de opgegeven kolom ($kolomindex)
    return clear($veld);
}

function elimineer_blok($veld, $x, $y, $sudoku) {
    // haal uit de array $veld alle waardes die al voorkomen in het blok, je moet aan de hand van de x/y positie zelf het blok bepalen.
    return clear($veld);
}

// Deze functie zorgt ervoor dat als het veld (array) nog één waarde heeft deze wordt omgezet naar een integer
function clear($veld) {
    if (count($veld) == 1) {
        return array_values($veld)[0];
    } else {
        return $veld;
    }
}
/*
Deze php-code zorgt ervoor dat de sudoku in een raster wordt getoond. Deze is direct zo gemaakt dat dit zowel een 4x4 als 9x9 kan zijn.
In principe hoeft er verder niets aan deze code te hoeven gewijzigd.
*/

$lijnen = array();
if(count($sudokuprint) == 9) {
    $lijnen = array(2, 5);
}
elseif (count($sudokuprint) == 4) {
    $lijnen = array(1);
}

foreach($sudokuprint as $y => $rij): ?>
    <div style="display: flex; height 50px; justify-content: flex-start; flex-direction: row;">
        <?php foreach($rij as $x => $veld): ?>
            <?php
            $stylegewijzigd = "";

            if(in_array($x, $lijnen)) $stylegewijzigd = "border-right: 2px solid #000000;";
            if(in_array($y, $lijnen)) $stylegewijzigd .= "border-bottom: 2px solid #000000;"
            ?>
            <div style="width: 70px; height: 50px; text-align: center; padding-top: 20px; border: 1px solid #666666; <?php echo $stylegewijzigd; ?>">
                <?php
                if(is_array($veld)) {
                    echo implode(",", $veld);
                } else {
                    echo $veld;
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
?>
