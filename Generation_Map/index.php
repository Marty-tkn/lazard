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
$saisie ="";
$saisieOk = false;
readline($saisie);


do{
    if($saisie == 0){
        $map->affichage();
        $saisieOk = true;
    }elseif($saisie == 1){
        $map->affichageJoueur();
        $saisieOk = true;
    }else{
        echo PHP_EOL."Mauvaise saisie , recommencer".PHP_EOL;
        $saisieOk = false;
    }
}while(!$saisieOk);


?>