<?php

//index combat

require "Generation_Map/map.php";
require "Lazard_combat/jeu.php";

$heros = new personnage("Heros",2, 100, false);


$r = new Room(Room::TREASURE_MONSTER_ROOM, 0, 0);
$r->setType(Room::ROOM | Room::MONSTER)->setX(1)->setY(5);

//index map


$jouerEncore = true;
$nbDeSalles = 10;

echo PHP_EOL."Menu 1 pour joueur , 0 pour dev".PHP_EOL;
$saisieOk = false;
$saisie = readline();

while($jouerEncore == true){

    echo "Bienvenue dans le donjon de LAZARD , survivras tu ?".PHP_EOL;
    echo " '[✪]' = Salle de depart".PHP_EOL;
    echo " '[ ]' = Salle vide".PHP_EOL;
    echo " '[☠]' = Salle du BOSS".PHP_EOL;
    echo " '[€]' = Salle avec coffre".PHP_EOL;
    echo " '[♀]' = Salle avec ennemie".PHP_EOL;
    echo " '[⁂]' = Salle avec coffre et ennemie".PHP_EOL;
    echo " '[♨]' = Salle avec feu de camp".PHP_EOL;

    //Permet de lancer les fonctions affichage et générations de ROOM------------------
    //Nombre de room type "WALL" vertical et horisontal (donc 10 = 100 WALL)
    $map = new Map($nbDeSalles);
    //Génére un nombre de ROOM (premier chiffre, donc 10 = 10 ROOM dans 100 WALL)------
    $map->generation($nbDeSalles,1);
    
    
    
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
    
    
            echo "Choisissez votre direction !",PHP_EOL;
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
            if($map->mappings[$map->PersoH][$map->PersoV]->_type == 5 || $map->mappings[$map->PersoH][$map->PersoV]->_type == 7 ){
                echo 'combat',PHP_EOL;
                $fight = new jeu();
                $mechant = new personnage("Mechant",mt_rand(0,2), mt_rand(10,30));
                $fight->begin($heros, $mechant,$map);
                unset($mechant);
                $map->mappings[$map->PersoH][$map->PersoV]->_type = 1;
            }
            $map->affichageJoueur().PHP_EOL;
            if($map->mappings[$map->PersoH][$map->PersoV]->_type == 32){
                echo 'combat de BOSS',PHP_EOL;
                $fight = new jeu();
                $boss = new personnage("L'emperor",mt_rand(0,3), mt_rand(20,40));
                $fight->begin($heros, $boss,$map);
                unset($boss);
            }
        }
    }

    echo PHP_EOL."Tu a vaincue le BOSS champion , veux tu passer au niveau suivant ?".PHP_EOL;
    echo "1 pour oui, 0 pour non";
    $saisieFinJeu = 1;
    $saisieFinJeu = readline();

    
    while($saisieFinJeu != 1 && $saisieFinJeu != 0){
        echo "erreur saisie recommencer".PHP_EOL;
        $saisieFinJeu = readline();
    }

    $nbDeSalles += 3;

    if($saisieFinJeu == 0){
        $jouerEncore = false;
    }

}

echo "A une prochaine fois CHAMPION !! ";




?>