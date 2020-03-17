<?php
function jeu($heros, $mechant)
{
    $tours = 0;
    if ($heros->initiative > $mechant->initiative) {
        while ($heros->vie > 0 && $mechant->vie > 0) {

            $tours = $tours + 1;

            print "Tours de jeu n°$tours : ";

            
            $mechant->mort();
            echo $mechant->nom, "  ", "Point de vie: ", $mechant->vie . PHP_EOL . PHP_EOL;
            print "Le méchant trés méchant attaque mechament" . PHP_EOL;
            $mechant->attaque($heros);
            $heros->mort();
            echo $heros->nom, "  ", "Point de vie: ", $heros->vie . PHP_EOL . PHP_EOL;
        }
    } else {
        while ($heros->vie >= 0 && $mechant->vie >= 0) {

            $tours = $tours + 1;

            print "Tours de jeu n°$tours : ";

            tourMechant($heros, $mechant);
            $heros->mort();
            echo $heros->nom, "  ", "Point de vie: ", $heros->vie . PHP_EOL . PHP_EOL;
            tourJoueur($heros, $mechant);
            $mechant->mort();
            echo $mechant->nom, "  ", "Point de vie: ", $mechant->vie . PHP_EOL . PHP_EOL;
            print "Le méchant très méchant attaque mechament !" . PHP_EOL;
        }
    }
    if ($heros->vie == 0) {
        print "GAME OVER !!" . PHP_EOL;
        print "1 pour recommencer/2 pour quitter";
        $restart = readline();
        if ($restart == 1) {
            restart($heros, $mechant);
            jeu($heros, $mechant);
        } else {
            print "Jeu fini.";
        }
    }
    if ($mechant->vie == 0) {
        print "VICTOIRE !!" . PHP_EOL;
        print "1 pour recommencer/2 pour quitter";
        $restart = readline();
        if ($restart == 1) {
            restart($heros, $mechant);
            jeu($heros, $mechant);
        } else {
            print "Jeu fini.";
        }
    }
    if ($mechant->vie == 0 && $heros->vie == 0) {
        print "EGALITE!!! PAS DE BOL !!!" . PHP_EOL;
        print "1 pour recommencer/2 pour quitter";
        $restart = readline();
        if ($restart == 1) {
            restart($heros, $mechant);
            jeu($heros, $mechant);
        } else {
            print "Jeu fini.";
        }
    }
}

function tourJoueur($heros, $mechant)
{
    print "A vous de jouez Héros !" . PHP_EOL;
    print "1: Attaquer  2: Soin  " . PHP_EOL;

    $action = readline();
    $chanceAction = rand(1, 6);
    if ($action == 1) {
        if ($chanceAction == 6) {
            $heros->attaqueCritique($mechant);
            print "ATTAQUE CRITIQUE !!" . PHP_EOL;
        } elseif ($chanceAction == 1) {
            $heros->attaqueLoupee();
        } else {
            $heros->attaque($mechant);
            print "Attaque lancé !" . PHP_EOL;
        }
    } elseif ($action == 2) {
        $heros->soin();
        
    } else {
        print "Mauvaise commande !" . PHP_EOL;
        tourJoueur($heros, $mechant);
    }
}


function tourMechant($heros, $mechant)
{
    $chanceAction = rand(1, 6);
    if ($chanceAction == 6) {
        $heros->attaqueCritique($mechant);
        print "ATTAQUE CRITIQUE !!" . PHP_EOL;
    }
    if ($chanceAction == 1) {
        $heros->attaqueLoupee();
    } else {
        $heros->attaque($mechant);
        print "Attaque lancé !" . PHP_EOL;
    }
}

function restart($heros, $mechant)
{
    $heros->vie = 100;
    $mechant->vie = 100;
}
