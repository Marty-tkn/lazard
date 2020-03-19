<?php

require "map.php";

$r = new Room(Room::TREASURE_MONSTER_ROOM, 0, 0);

$r->setType(Room::ROOM | Room::MONSTER)->setX(1)->setY(5);

//Permet de lancer les fonctions affichage et générations de ROOM------------------
//Nombre de room type "WALL" vertical et horisontal (donc 10 = 100 WALL)
$map = new Map(10);
//Génére un nombre de ROOM (premier chiffre, donc 10 = 10 ROOM dans 100 WALL)------
$map->generation(10,1);

echo "Menu 1 pour joueur , 0 pour dev";
$saisieOk = false;
$saisie = readline();



do{
    if($saisie == 0){
        $map->affichage().PHP_EOL;
        $saisieOk = true;
    }elseif($saisie == 1){
        $map->affichageJoueur().PHP_EOL;
        $saisieOk = true;
    }elseif($saisie != 0 && $saisie != 1){
        echo PHP_EOL."Mauvaise saisie , recommencer".PHP_EOL;
        $saisieOk = false;
        $saisie = readline();
    }
}while(!$saisieOk);

if($saisie == 1){
    while($map->mappings[$map->PersoH][$map->PersoV]->_type != 32){
        $verifDroite = false;
        $verifGauche = false;
        $verifHaut = false;
        $verifBas = false;

        if(isset($map->mappings[$map->PersoH][$map->PersoV+1]) && $map->mappings[$map->PersoH][$map->PersoV+1]->_type != 0){
            echo 'droite ?'.PHP_EOL;
            $verifDroite = true;
        }
        if(isset($map->mappings[$map->PersoH][$map->PersoV-1]) && $map->mappings[$map->PersoH][$map->PersoV-1]->_type != 0){
            echo 'gauche ?'.PHP_EOL;
            $verifGauche = true;
        }
        if(isset($map->mappings[$map->PersoH+1][$map->PersoV]) && $map->mappings[$map->PersoH+1][$map->PersoV]->_type != 0){
            echo 'bas ?'.PHP_EOL;            
            $verifBas = true;
        }
        if(isset($map->mappings[$map->PersoH-1][$map->PersoV]) && $map->mappings[$map->PersoH-1][$map->PersoV]->_type != 0){
            echo 'haut ?'.PHP_EOL;
            $verifHaut = true;
        }

        $saisieDirection = readline();

        if(($saisieDirection == "droite" || $saisieDirection == "Droite" || $saisieDirection == "d" || $saisieDirection == "D") && $verifDroite == true){
            $map->PersoV += 1;
            $map->affichageJoueur().PHP_EOL;
        }
        if(($saisieDirection == "gauche" || $saisieDirection == "Gauche" || $saisieDirection == "g" || $saisieDirection == "G") &&  $verifGauche == true){
            $map->PersoV -= 1;
            $map->affichageJoueur().PHP_EOL;
        }
        if(($saisieDirection == "bas" || $saisieDirection == "Bas" || $saisieDirection == "b" || $saisieDirection == "B") && $verifBas == true){
            $map->PersoH += 1;
            $map->affichageJoueur().PHP_EOL;
        }
        if(($saisieDirection == "haut" || $saisieDirection == "Haut" || $saisieDirection == "h" || $saisieDirection == "H") && $verifHaut == true){
            $map->PersoH -= 1;
            $map->affichageJoueur().PHP_EOL;
        }

    }
}

?>