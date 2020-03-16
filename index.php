<?php
require 'perso.php';

$JohnSnow = new personnage('Chuck',$armor=5);
$rob = new personnage('Corona');
$tour = 0;

while ($JohnSnow->hp !=0 || $rob->hp !=0){    
    $JohnSnow->fight($rob);
    $JohnSnow->state();
    $rob->attack($JohnSnow).PHP_EOL;
    $tour++;
}


// Coder la fonction DEF!!! while/for de fait... mais comment les utiliser?