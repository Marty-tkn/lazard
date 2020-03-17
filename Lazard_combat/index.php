<?php

require "jeu.php";

$heros = new personnage("Heros", 100, false);
$mechant = new personnage("Mechant", 100);


$fight = new jeu();
$playAgain = 1;


while ($playAgain == 1) {
    $fight->begin($heros, $mechant, $playAgain);

    echo 'Voulez vous recommencer ?', PHP_EOL, '1: pour recommencer/2: pour quitter';
    $playAgain = readline();
    switch ($playAgain) {
        case 1:
            echo 'Nouveau combat';
            $fight->begin($heros, $mechant);
            $heros->vie = 100;
            $mechant->vie = 100;
            break;
        case 2:
            echo 'Merci d\'avoir joué :)',PHP_EOL;

            break;
    }
}
echo $fight->victoiresHeros , PHP_EOL;
echo $fight->victoiresMechant , PHP_EOL;

