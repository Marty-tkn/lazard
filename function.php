<?php

function fight($JohnSnow,$rob){
    $fight = readline();
    switch ($fight){
        case 1:
            $JohnSnow->attack($rob);
        break;

        case 2:
            $JohnSnow->heal();
        break;

        default:
        print "Taper 1 ou 2".PHP_EOL;
        fight($JohnSnow,$rob);
    }
}