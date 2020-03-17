<?php

class Map{
    protected $_mapping;
    private $_size;
    
    //Fonction pour créer un tableau représentant la carte (pas encore généré et affiché)-----------
    public function __construct($size=5){
        $this->_size = $size;
        $this->mappings = array();
        for($i=0; $i< $size; $i++){
            $this->mappings[] = array();
            for($j=0; $j < $size; $j++){
                $this->mappings[$i][$j] = new Room(Room::WALL, $i, $j);
            }
        }
    }

    //Fonction pour afficher la carte sur le terminal avec les symboles des ROOM -----------------
    public function affichage(){
        $i=0;
        foreach($this->mappings as $hori){
            $y=0;
            foreach($hori as $verti){
                //Définie le symbole sur le "TERMINAL" ----------------------------------
                if($this->mappings[$i][$y]->_type==0){
                    echo '[█]';
                }elseif($this->mappings[$i][$y]->_type == Room::START){
                    echo '[✪]';
                }elseif($this->mappings[$i][$y]->_type == Room::ROOM){
                    echo '[ ]';
                }elseif($this->mappings[$i][$y]->_type == Room::BOSS){
                    echo '[☠]';
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_TREASURE){
                    echo '[€]';
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_MONSTER) {
                    echo '[♀]';
                }elseif ($this->mappings[$i][$y]->_type == Room::TREASURE_MONSTER_ROOM) {
                    echo '[⁂]';
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_FIRE_CAMP) {
                    echo '[♨]';
                }
                $y++;
            }
            echo PHP_EOL;
            $i++;
        }
    }

    //Cette fonction permet de créer une carte aléatoirement avec un nombre aléatoire de ROOM ----------------------------
    public function generation($nbRoom=15,$nbBoss=1,$nbtreasure=2,$nbMonstre=5,$nbFeuDeCamp=1){
        $h = mt_rand(1,$this->_size-2);
        $v = mt_rand(1, $this->_size-2);
        $this->mappings[$h][$v]->_type=Room::START;
        $compteur = mt_rand(round((mt_rand(60,80)/100*$nbRoom), 0),$nbRoom);
        /* echo $compteur; */
        //Génération de ROOM aléatoire -----------------------------------------
        $room = 0;
        while($room <= $compteur){
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            $hasard = mt_rand(0, 10);
            if(($hr > 0 && $hr < $this->_size-1) && ($vr > 0 && $vr < $this->_size - 1 && $this->mappings[$hr][$vr]->_type == Room::WALL)){
                    if ($this->mappings[$hr + 1][$vr]->_type != 0 || $this->mappings[$hr-1][$vr]->_type != 0 || $this->mappings[$hr][$vr + 1]->_type != 0 || $this->mappings[$hr][$vr- 1]->_type != 0) {
                        //condition pour générer des couloirs plus que des patées -------------------------
                        if($hasard <= 9 && $this->mappings[$hr + 1][$vr]->_type != 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0){
                            $this->mappings[$hr][$vr]->_type = Room::ROOM;
                            $room++;
                        }
                        if ($hasard <= 9 && $this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type != 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                            $this->mappings[$hr][$vr]->_type = Room::ROOM;
                            $room++;
                        }
                        if ($hasard <= 9 && $this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type != 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                            $this->mappings[$hr][$vr]->_type = Room::ROOM;
                            $room++;
                        }
                        if ($hasard <= 9 && $this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type != 0) {
                            $this->mappings[$hr][$vr]->_type = Room::ROOM;
                            $room++;
                        }
                        if($hasard == 10){
                            //garder les 2 lignes du dessous si on doit remettre à zero
                            $this->mappings[$hr][$vr]->_type=Room::ROOM;
                            $room++;
                        }
                    }
            }

        }
        //Générer un boss en position aléatoire mais toujours au fond d'un couloir----------------------------
        $boss = 0;
        while($boss < $nbBoss){
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            if (($hr > 0 && $hr < $this->_size - 1) && ($vr > 0 && $vr < $this->_size - 1 && $this->mappings[$hr][$vr]->_type == Room::WALL)) {
                if ($this->mappings[$hr + 1][$vr]->_type != 0 || $this->mappings[$hr - 1][$vr]->_type != 0 || $this->mappings[$hr][$vr + 1]->_type != 0 || $this->mappings[$hr][$vr - 1]->_type != 0) {
                    if ($this->mappings[$hr + 1][$vr]->_type != 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type != 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type != 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type != 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                    }



                }
            }
        }
        // Générer des trésors en position aléatoirs mais dans une ROOM ------------------------
        $treasure = 0;
            // Générer automatiquement un trésor en % de la taille de la MAP------------------------
        $hasardTreasure = mt_rand(10,15);
        $nbtreasure = round($nbRoom / 100 * $hasardTreasure);

        while($treasure < $nbtreasure){
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            if ($this->mappings[$hr][$vr]->_type == 1 ) {
                $this->mappings[$hr][$vr]->_type = Room::ROOM | Room::TREASURE;
                $treasure++;
            }
        }
        // Générer des monstres en position aléatoirs mais dans une ROOM ------------------------
        $monstre = 0;
            // Générer automatiquement des monstres en % de la taille de la MAP------------------------
        $hasardMonstre = mt_rand(20, 30);
        $nbMonstre = round($nbRoom / 100 * $hasardMonstre);

        while($monstre < $nbMonstre){
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            $hasardMonstreTreasure = mt_rand(1, 10);
            if ($this->mappings[$hr][$vr]->_type == 1) {
                if($hasardMonstreTreasure <= 8){
                    $this->mappings[$hr][$vr]->_type = Room::MONSTER | Room::ROOM;
                    $monstre++;
                }
                if ($hasardMonstreTreasure >= 9) {
                    $this->mappings[$hr][$vr]->_type = Room::ROOM | Room::TREASURE | Room::MONSTER;
                    $monstre++;
                }
            }
        }
        // Générer un feu de camp en position aléatoirs mais dans une ROOM ------------------------
        $feuDeCamp = 0;
            // Générer automatiquement un feu de camp en % de la taille de la MAP (20 room = 2 feux)------------------------
        $nbFeuDeCamp = round($nbRoom / 100 * 5);
        while ($feuDeCamp < $nbFeuDeCamp) {
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            if ($this->mappings[$hr][$vr]->_type == 1) {
                $this->mappings[$hr][$vr]->_type = Room::ROOM | Room::FIRE_CAMP;
                $feuDeCamp++; 
            }
        }
    }
}

class Room{

    //Les différentes ROOM que l'on peu trouver dans la carte. Les valeurs sont toujours x2 pour
    //éviter que les valeurs ne ce chevauches quand on additionne les valeurs de ROOM entre-elles --------------
    //Exemple : "ROOM"=1 + "TREASURE" => "ROOM_TREASURE"=3 || Donc ne pas prendre la valeur 3 pour une nouvelle ROOM sinon les 2 valeurs se chevauche
    public const WALL=0;
    public const ROOM=1;
    public const TREASURE=2;
    public const MONSTER=4;
    public const TRAP=8;
    public const START=16;
    public const BOSS=32;
    public const FIRE_CAMP=64;
    public const TREASURE_MONSTER_ROOM= Room::ROOM | Room::TREASURE | Room::MONSTER;
    public const ROOM_MONSTER= Room::ROOM | Room::MONSTER;
    public const ROOM_TREASURE= Room::ROOM | Room::TREASURE;
    public const ROOM_FIRE_CAMP= Room::ROOM | Room::FIRE_CAMP;
    // Coordonnées de la salle sur la map
    protected $_x;
    protected $_y;
    // WALL, EMPTY_ROOM, TREASURE_ROOM, MONSTER_ROOM, TREASURE_MONSTER_ROOM, TRAP_ROOM
    public $_type;

    public function __construct($type=Room::WALL,$x, $y){
        $this->_type = $type;
        $this->setX($x)->setY($y);
    }

    public function setX($x){
        $this->_x = min(max(0, $x),200);
        return $this;
    }

    public function setY($y){
        $this->_y = min(max(0, $y), 200);
        return $this;
    }

    public function setType($type){
        $this->_type = $type;
        return $this;
    }

    public function getX(){
        return $this->_x;
    }

    public function getY(){
        return $this->_y;
    }

    public function getType(){
        return $this->_type;
    }

    public function presence($type){
        if($type == Room::WALL)
            return $this->_type == $type;
        else
            return ($this->_type & $type) == $type;
    }
}


$r = new Room(Room::TREASURE_MONSTER_ROOM, 0, 0);

$r->setType(Room::ROOM | Room::MONSTER)->setX(1)->setY(5);

//Permet de lancer les fonctions affichage et générations de ROOM------------------
//Nombre de room type "WALL" vertical et horisontal (donc 10 = 100 WALL)
$map = new Map(10);
//Génére un nombre de ROOM (premier chiffre, donc 10 = 10 ROOM dans 100 WALL)------
$map->generation(10,1);
$map->affichage();



                    // ______§§§§§____________________________________________________________§§§§§§§§_________
                    // _______§§§§§§§§§______________________________________________________§§§§§§§§§§_________
                    // ________§§§§§§§§§§§§________________________________________________§§§§§§§§§§§§_________
                    // ________§§§§§§§§§§§§§§§§__________________________________________§§§§§§§§§§§§§§_________
                    // _________§§§§§§§§§§§§§§§§§§_____________________________________§§§§§§§§§§§§§§§§_________
                    // _________§§§§§§§§§§§§§§§§§§§§§_________________________________§§§§§§§§§§§§§§§§§_________
                    // __________§§§§§§§§§§§§§§§§§§§§§§§_____________________________§§§§§§§§§§§§§§§§§__________
                    // ___________§§§§§§§§§§§§§§§§§§§§§§§§__________________________§§§§§§§§§§§§§§§§§§__________
                    // _____________§§§§§§§§§§§§§§§§§§§§§§§§§______________________§§§§§§§§§§§§§§§§§§§__________
                    // ______________§§§§§§§§§§§§§§§§§§§§§§§§§§___________________§§§§§§§§§§§§§§§§§§§§__________
                    // ________________§§§§§§§§§§§§§§§§§§§§§§§§§_________________§§§§§§§§§§§§§§§§§§§§___________
                    // _________________§§§§§§§§§§§§§§§§§§§§§§§§§§_______________§§§§§§§§§§§§§§§§§§§§___________
                    // ___________________§§§§§§§§§§§§§§§§§§§§§§§§§§_____________§§§§§§§§§§§§§§§§§§§____________
                    // ______________________§§§§§§§§§§§§§§§§§§§§§§§§§__________§§§§§§§§§§§§§§§§§§§§____________
                    // ________________________§§§§§§§§§§§§§§§§§§§§§§§§§________§§§§§§§§§§§§§§§§§§§_____________
                    // ___________________________§§§§§§§§§§§§§§§§§§§§§§§_______§§§§§§§§§§§§§§§§§§______________
                    // ______________________________§§§§§§§§§§§§§§§§§§§§§§_____§§§§§§§§§§§§§§§§§_______________
                    // ___________________________________§§§§§§§§§§§§§§§§§§§___§§§§§§§§§§§§§§§§________________
                    // ________________________________________§§§§§§§§§§§§§§§__§§§§§§§§§§§§§§__________________
                    // ______________________________________________§§§§§§§§§§§§§§§§§§§§§§§§___________________
                    // ________________________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§_____________________
                    // _________________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§_______________________
                    // ______________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§______________________
                    // ___________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§____________________
                    // _________________________§§§§§§§§_____§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§___________________
                    // _______________________§§§§§§§§§_______§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§__________________
                    // _____________________§§§§§§§§§§§_______§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ____________________§§§§§§§§§§§§§_____§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ___________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ___________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§MaBite§§§§§§§§§§§§________________
                    // ___________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ___________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ____________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // ______________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§________________
                    // _________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§_________________
                    // _____________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§__________________
                    // ___________________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§__________________
                    // _____________________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§___________________
                    // _____________________________________§§§§§§§§§§§§§§§§§§§§§§§§§§§§§_______________________
                    // ____________________________________§§§§§§§§§§_____§§§§§§§§§§____________________________
                    // _____________________________________§§§§§_________§§§§§_________§§§§§___________________
                    // ______________________________§§§§_________§§§§____________§§§§§§§§§_____________________
                    // ______________________________§§§§§§§§§§§§§§§§§_____§§§§§§§§§§___________________________
                    // ______________________________§§§§§§§§§§§§§§§§§___§§§§§__________________________________
                    // ______________________________§§§§§______§§§§§§__________________________________________
                    // ____________________________________________§§§__________________________________________
                    // _________________________________________________________________________________________

/*           ______s__
          /         \
         (  {   @  @ )
         |        *   \
         |__    `---'  |
  ,     /   \________,/\
, ||   /  .  (    . . ) |
<[||II'  (        -+- | /  _
 \____,__/\________o__/\\ < >ooo
        |     ___    ,--*-- ~~~)
         \   /   \   ;     .  /
      ~~~~~-+     +--'--^--`-+~~~
             > *  <
             |    /
             >'   )
            /... /
           ooo<_>


/*  */
------------------------------------------------
Thank you for visiting https://asciiart.website/
This ASCII pic can be found at
https://asciiart.website/index.php?art=people/babies
*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                     //
//                                                                                                     //

// ESSAIE ET TEST !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


/* for($i=0, $x=0; $i<=4; $i++,$x++){
    $x = array(1=>$i, 2=>$i, 3=>$i);
}
print_r(array_keys($x));
 */
// $A = array(1, 2, 3, 4, 5);
// $B = array(1, 2, 3, 4, 5);
// $C = array(1, 2, 3, 4, 5);
// $D = array(1, 2, 3, 4, 5);
// $E = array(1, 2, 3, 4, 5);

/*
$size = 10;
$map = array_fill(0,$size,array_fill(0,$size,' '));

for($j=0; $j < $size; $j++){
    $map[0][$j] = '#';
    $map[$size-1][$j] = '#';
    $map[$j][0] = '#';
    $map[$j][$size-1] = '#';
}

$x1 = mt_rand(1,$size-2);
$x2 = mt_rand(1, $size - 2);
$map[$x1][0]=' ';
$map[$x2][$size-1] = ' ';
function display_map($map){
    foreach($map as $row){
        foreach($row as $col){
            echo $col;
        }
        echo PHP_EOL;
    }
}

display_map($map);
/**/


// function affichageDamier($tableau)
// {
//     print PHP_EOL . PHP_EOL;
//     for ($i = 0; $i < 5; $i++) {
//         for ($x = 0; $x < 5; $x++) {
//             print $tableau[$i][$x] . " ";
//         }
//         print PHP_EOL;
//     }
// }

// function depart($tabhorizontal, $tabVertical){
//     $toto = array();
//     $hor = mt_rand(0, count($tabhorizontal));
//     $vert = mt_rand(0, count($tabVertical));

//     $toto[]= $hor;
//     $toto[]= $vert;

//     return $toto;
// }

//                                                                                             //
//                                                                                             //
/////////////////////////////////////////////////////////////////////////////////////////////////
/* XXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKK0000OkkOOOOkkkxkOxdddxkkkkOkO0OOOO00OOO00kxxxkO00O0OO0OOO00K0O000OOOO0OOOOOkOOOOOOOOOOOOOOOOOOOkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKK000OOkOOOOOOOOkOOxddxkOOOO0OOO0000000OOO00kkxxk0000OOO0OO000K00000OOOOOOOOOOOOOOOOOOOOOOOOOOOOOkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKK0000OkkOO0000OOO0OxxxxkO0O00000000000K000O00kxxdx0K000OO0O0000K00K0OOOOOOOOOOkOOOOOOOOOOOOOOOOOOOkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKK0000OkkO000K00kO00OkxxxxO00000K0000000KK00000OkkddkKK000O00O000K000K0OO000OOOOOOOOOOOOOOOOOOOOOOOkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKK00OOOOkk000KK0OkO00Okkxddk0K000000000OO0KKK0000OkxddOKK0000000000K0000OO0000OOOOOOOOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKXKKKK00OOOkkOkk000000Okk000OkxddkO0000KK0000OOO0KK00000Okxdx0KK0000K0000000000O00000OOOOkkOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKXKKKK0OOOkkkOkkO000OOOkkO00OkxddxkO000000000OkkOO000000OOkxdOKKK000K00000000000O00OO0OOOOkOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKXXXKK00OkkkxxkkxkOOOOkkxkO00OkxxxxxkOOOOO0OOO0OkkkOOOOOO0OOxdOKKKK00000000000000O00OO00OOOOOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKK0OOkkxxxxxdxOOOOkxxkOO0OOkkkkkkkkOOkOOOOOOkxxkkOkkOO0Okxk0K0KK00000000000000000OOOOOOOOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKK0OOkkxxddooxkkkkxxxkOOOOOOOOkkkkkkOkkkkOkkOkxxxkkkkkOOOxx0K0K000000000000000O000OOOOOOOOOOOOOOOOOOOOkkkkkkk
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKK00OkxxxddoldkkkkxxkkOOOOO000OOOkkkkkkkkkkkkkxxdxkxkkkOOkxO00K000000000000000O000OOO00OOOOOOOOOOOOOOOkkkkkkk
XXXXNNNNNNXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKK00OkkxxddllodxxxkkkOOOO00000000OOOO00OOOOOOOOOkkxxxxxxkOkk00K00000O000000000OO000OOOOOOOOOOOOOOOOOOOkkkkkkk
NNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXKK00OOkxxddlclllllcccodkO00O0000O000000OkxxddddxxxxxxddddxkO000K0K0000K0000000000000OOOOOOOOOOOOOOOOkkkkkkkkk
NNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXKK00OOkxxdolodxxxdol:;;:lxkkO000OOOO0Odlcc::cclodxkkkkxdolok00000KK000KK000000000000OOOOOOOOOOOOOOOkkkkkkkkkk
NNNNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXKK00OkkxdolloxddddoollccccdxkO00OOOOkdolllodxxkkkOOOOOOkxocoO00000K00O0KK0000000000OOOOOOOOOOOOOOOOkkkkkkkkkk
NNNNNNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXKK0OOkkxddllooc;'''.'',;:cloxO000OOkxdodddolclllooxkkkkkxdlcx000000000O0K00000000000OOOOOOOOOOOOOOOkkkkkkkkxx
NNNNNNNNNNNNNNNNNNNNNNXNNNXXXXXXXXXXXXXXKKK0OOkxdddoll:'.'::,'..'';:ldO000Okxddodo:,,,;,'''';coxkxdlclk000000K0O0KK0000K00000OOOOOOOOOOOOOkkkkkkkkkkxx
NNNNNNNNNNNNNNNNNNNNNNXXNNXXXXXXXXXXXXXXKKK0OOkxddoooollllll:;,;::;;cxO00Okxxdolc:,,;ll:,..'',;cddollcd0000O000O00K0000KK00000OOOOOOOOOOOOkkkkkkkkkxxx
NNNNNNNNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXKK00OkxddooodxxxxxddoodddooldO00Okxxxxddolccloolllldddooddolllok0000000OO000000KK000K0OOOOOOOOOOOkkkkkkkkkxxxx
NNNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXK00OkxdddoodxkkOkkxxxxkxxddOO0OkkxxxxxxxxdddddddddxxkkOkkxooolx0O000000O00000O0K00000OOOOOOOOOOOkkkkkkkkxxxxx
NNNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXKK00OkxxddoodxkOO000000Okxxk000OkkkkkkkkkkkkkkxxxkkOOOOOkkxdoolokOO00000OO0000O0K0O000OOOOkkkkOOkkkkkkkkkxxxxx
NNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXKK0OOkxxdooddxkOO00000OkxxkO000OkkkOkkkOOOOOOOOOOOOOOOOOkkxdollloOkk00OOOOOO0OO0000000OOkOkkkkOOkkkkkkkkxxxxxx
NNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXKK0OOkkxddddxkOO00000OOxxkO000OkkkkkkkkOOOOOOOOOOO00OOOOkkxdolll:oOO00OOOOOOOOO000O0000OOOkkkkkkkkkkkkxxxxxxxd
NNNNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXK00OOkkxddddxkOO000OOOkkkO0000OOkkkkkkkOOO0OOOO000000OOOkkxdollc:cxOO0OOOOOOOkO00OO0000Okkkkkkkkkkkkkkxxxxxxdd
NNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXXKK00OOkxdddooxxkOOOOkkxxkO000000OkkkkkxxxxkOOOOO00000OOOkkkxdollc:;lkOOOOOOkOkkOOOOOO000Okkkkkkkkkkkkkkxxxxxxdd
NNNNNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXXKK00OOkxddolodxkkkkxdoodxOO00OOkkkkkkOkkdodxxkkkkkOOkkkkkkxxdollc;;cxOOOOOOkkkkkOOOOOO0Okkkxxkkkkkkkkkxxxxxxxdd
NNNNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXXKKKKK00Okxddolclddxxxollooddxxxkxdlc::lodxxddxxxxxddxxkkkkkxxxxdolc:;;cxOOOOOkkkkkkkOkOOOOOkkkxxkkkkkkkkkxxxxxxxdd
NNNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKK00Okxdoolccoddol:cooooodoooolccccccloxkkkkkxxdddxxxxxxxxxxdolc:;:okOOOOkkkkxxkkkkkOOOOkkkxkkkkkkkkkxxxxxxxddd
NNNNNNNNNXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKK00Okxdolc:coddocloooooooooooooddxxxxkkkkkkkkkxdoddddddddxxxolc::lxkOOOkkkkxxkkkkkkkOOkkkxxkkkkkkkkkxxxxxxxddd
NNNNNNXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKK0OOOxollc::ldxdlloooooodddxkkkxxkkkkOOOOOOOkkkxdoodddddxxxxdlc:ldkkOOOkkkxdxkxxxxxkOkkkkxxkkkkkkkkkxxxxxxdddd
NNNNNXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK0K0OOOxolcc::ldxxololc:::lodxkOOkkkkkkkkkkkkkkxxxxdoodkxxkkkxdlcoxkkkOOOkkxddxxxxxxxkkkkkxxxkkkkkkkkxxxxxxxdddd
NNNXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK000000OOkdlcc::coxxdooo:'..:olloooooolllllolc::::ccloddxOkkkkkxdodxkkkkOOkkxdddxxxxxxxkkxxxxxxkkkkkkkkxxxxxxxdddd
NNXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK00000000OOkxolc:::cdxxddddc,.,dkk0Ok  Ok  kkOxolcc,,:oxkxkOOOOkkxxxkOOOOkkkxdoodxxxxxdxxxxddxxxkOOkkkkkkxxxxxxxdddd
XXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK000000000OOkkdolc:;:lxkkxxxxo;.,lkK00  00  Okxol::ccokOOkkOOkOOkkkkOOOOOOkxollodxxdxdddxxddddxxkOOkkkkkkkxxxxxxxdddd
XXXXXXXXXXXXXXXXXKKKKKKKKKKKKK0000000000000OOkkxdoc::;:oxkkkxxxo;',lodddxoloooccclooxkOOOOOOOkkkOkOOOOOOOOxoc:coddddddddxxdddddxkOOOkkkkkkkxxxxxxxdddd
XXXXXXXXXXXXXXXXXKKKKKKKKKKK000000000000000OOOkkxddolccldxOOkxkxl::clllloooooooodkOOOOOOkOOOOOOOOOOOOOOxol:;:cldddddddddxddoddxkOOOOOkkkkkkxxxxxxxxxdd
XXXXXXXXXXXXXXKKKKKKKKKKKKK00000000000000000OOkkkxxdddlcldkOkxxxdolloooooodddxxddxOO00OOOOOOOOOOOOkkxdl:;,;;cloddddddddxddoodxkOOOOOOkkkkkkkxxxxxxxddd
XXXXXXXXXXXKKKKKKKKKKKKKKK0000000000000000000OOkkkkkxxdlclxkOkxxxxxxxxxxxxxxkkxddddxkkkkkOkkkkxxxdolc;;;;;:cldddddddddxdoooodkOOOOOOOkkkkkkkkxxxxxxddd
XXXXXXXXXKKKKKKKKKKKKKK000000000000000000000000OOOkkxxdolcoxkkkxxxxkkkkkkkkkkkkxdoodddxxxdoodooollc;;;;:clloddddddddxxdooodxkOOOOOOOOkkkkkkkkxxxxxxddd
XXXXXXXXXKKKKKKKKKKKKK00000000000000000000000000000OOOkdolldxkkkkkkkkkkkkkkkkkkkxxxdddddolloooollcccclloollodddddddddoldkOO0000OOOOOOOkkkkkkkxxxxxxxdd
XXXXXXXXKKKKKKKKKKKKKK0000000000000000000000000000000000OkxxxxxkkOOOO000OOO0000OOOkkxxdoloddoool::ccccccclooddddddolclxO0000000OOOOOOOOkkkkkkkxxxxxxxd
XXXXXXXKKKKKKKKKKKKKK000000000000000000000000000000000000000OkxxkkOO000000000000OOkkkxddxxdddolc::;,,''';cllllllccclxO0K00000000OOOOOOOkkkkkkkxxxxxxxx
XXXXXXKKKKKKKKKKKKKKK00000000000000000000000000000000000000000OkxxkOOOOOOOOOOOOkkkkxddxxxddoodddol:;,,'',ldddddddxO0KKKKKK0000000OOOOOOOkkkkkkkxxxxxxx
XXXXXKKKKKKKKKKKKKKK0000000000000000000000000000000000000000000kdxxxkkkkkkkkxxxxxdddddddddddxxkxxdl:;;;;;dKXKKKKKKKKKKKKKKK0000000OOOOOOOkkkkkkkxxxxxx
XXXXXKKKKKKKKKKKKK00000000000000000000000000000000000000000000OxddddddddddddddoooolloooddxkkkkkkxdoccccccdKXXXXKKKKKKKKKKKKK00000000OOOOOOOkkkkkkkxxxx
XXXXXKKKKKKKKKKKKK00000000000000000000000000000000000000000000kddddddddooollllllllllodxkkkkkkkkkxdoolloood0XXXXXXXKKKKKKKKKKK0000000OOOOOOOOkkkkkkxxxx
XXXXXKKKKKKKKKKKKKK000000000000000000000000000000000000000000OdodddddddddooooddddxxkkkOkkkkkkkkxxdddddddddOXXXXXXXKKKKKKKKKKK00000000OOOOOOOOkkkkkkkkx
XXXXXKKKKKKKKKKKKK000000000000000000000000000000000000000000OxodddddddxxkkkkkkkkkOOOOOOkkkkkOkkxxddxxxxxxdkKXXXXXXXKKKKKKKKKKKK00000000OOOOOOOOkkkkkkk
XXXXXKKKKKKKKKKKK00K000000000000000000000000000000000000OOOkxdddddddddxxkOOOO0OOOOOOOOOOOOOOOOkkxxxxkkxxxxdOXXXXXXXXXKKKKKKKKKKK00000000OOOOOOOkkkkkkk
XXXXXXKKKKKKKKKKK000000000000000000000000000000000000000kxkOxxddddddddxxkkOOO000OOkkOOOOOOOOOOkkxxxkkkkxxxxxO0KXXXXXXKKKKKKKKKKK000000000OOOOOOOOkkkkk
XXXXXKKK000000000000000000000000000000000000000000000OO0OO0KK0kxdddxxxxxkkkkkOO0OOOkkkOO00000OOkxxxkkkkxxxxxxOKKXXXXXXXXKKKKKKKKK000000000OOOOOOOkkkkk
XXKK0000000000000000OOOOOOOOOOOOOOOOOOOOOO0000OOO0OOOOOOOOOOO0K00OOkkkkkkkOOkkOOOOOOkkkkOOOO000000O0000OOOkO000KXXXXXXXXXKKKKKKKKKK00000000OOOOOOOOkkk
0000000000000000000000000OOOOOOOOOOOOOOO000KKKKK0000000000000OOO000K00K00K0O0KO0K00K0OKOOKOO00O0O0OOOkkkkkOOOkxkOKXXXXXXKKKKKKKKKKKK0000000OOOOOOOOkkk
00000000000000000000000000000000OOOOOO00000KKKK000000000000000000O0OO00O00OO00OOK0O0OOOOOOOOOOOOOOOOkkkkxxxxkkkkkkO00KKKKKKKKKKKKKKKK0000000OOOOOOOOkk
000KKKKKKKKK0KK00KK00000000000000000000OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO00000OOOOOOOOO00O0OOOOOOOkkkkkkkkOOOOOOOOO00000000000KK00000000OOOOOOOkk
KKKKKKKKKKKKKKKKKKKKK0000000000000000000OOOOOOOOOOOOOOOOOOOOOOOOOOOOkkkOkkkOkkOOOOOOOOOOOkkOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO0000000OOOOOOO000000OOOOOOOOk
KKKKKKKKKKKKKKKKKKKKKKK0000000000KKK00000000000000000000OOOOOOOOOOOOOOOOOOOOOkkkkkkkkkOOkkkkkkkkkOOOOOOOOOOOOOOOkkkOOOOOOO00KK000000OOOkkkOOOOOOOkOOkk
KKKKKKKKKKKKKKKKKKKKKKKKKKK00000KKKKK0000000000000000000000000000000000000OOOOOOOOOOOOOOOOOOOkkkkkkkkkOOOOOOOOOOOOOOkkkkkkOO000000000OOOkkkkkkkkkkkkkk
KKKKKKKKKKKKKKKKKKKKKKKKKKKK00KKKKKKKKKKKKKKKK0000000000000000000000000000000000000OOOOOOOOOOOOOOOOkkkkkOOOOOOOOOOOOOOkkkkOOOOO00000000OO000000OOOOOOO
KXKKKKKKKKKKKKKKKKKKKKKKKKKK0KKKKKKKKKKKKKKKKKKKKK00K00000000000000000000000000000000000000OO00OOOOOOOOOOOOOOOO0000000OOOOOOOOOOO000000000000000000000
KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKXKKKKKKKKKKKKKKK000000000000000000000000000000000000000000OOOOO000OOOOO000000000000OOOOOOOOOOO000000KK000K0000000
KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKXXXXXXXKKKKKKKKKKKKKKK00000000000000000000000000000000000000000000OOOOOOO000000000000000000000OOOOO000000KK00KKKKKK000
KKKKKKKK000KKKKKKKKKKKKKKKKKKKKXXXXXXXXXKXXKKKKKKKKKKKKKKK000000KKKKKKK0000KKKKKKKK0000000KK0000000OOOOOO000000000000000000000000OO0000000KKKKKKKK0000
KKKK000000000KKKKKKKKKKKKKKKKKKXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK000000OOOO000000000000000000000000000000000KKKKKK00000
KKK0000OOOOO0000KKKKKKKKKKKKKKKKXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK000000OO0000000000000000000000000000O0000K0KKKK0KKK
KK0000OOkkkxxkkOO00KKKKKKKKKKKKKXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK00000000000000000000000000000000000000000KKKKKKK
K000OOkkxdoolccoxO0KKKKKKKKKKKKXXXXXXXXXXXXXXXXXKKXKKKKKKKKKKKKKXXXKKKKKKKKKKKKKKKKKKKXXXXKKKKKKKKKKKKK000000000KK000KK000000000000000000000000KKKKKKK
0000Okkxdddddl:;cdO0KKKKKKKKKKXXXXXXXXXXXXXXXXXXKXXKKKKKKXXKKKXXXXXXKKKKKKKKKKKKKKKKKKXXXXXKKKKKKKKKKKKKKK000000KKKKKKKKKKKKKKKKK0000000000000KKKKKKKK
000Okxddddddol:;,;oO0KKKKXXXXXXXXXXXXXXXXXXXXXXKKKXKKKKXXXKKKKXXXXXXXXXXXXKKKXXKKKKXXXXXXXXXXKKKKKKKKKKKKKK00000KKKKKKKKKKKKKKKKKKK0000000000KKKKKKKKK
0OOkxoooolllooc:,';lx0KKXXXXXXXXXXXXXXXXXXXXXKXKKKKKXXXKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK0000000000KKKKKKKK
Okxollllloddxxdl:;;;lxO0KXXXXXXXXXXXXXXXXXXXXXXKKKKKXXKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK0000000000KKKKK00
xolcllodddddxxxxoc:::lxO0KKXXXXXXXXXXXXXXXXXXXXKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK000000000000000O
c::clllooooodxxkkdolcclxO0KKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKK00000000OOkkxdo
ccccclloooddxxkOOkxdooodxk0KKKKXXXXXXXXXXXXXKXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKK00000OOkdllc::
lc::cllooddxxkOOOOOkxxdxxkO0KKKKKXXXXXXXKXXXKXXKKXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKXXNNXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKK0000OOkdl:;;:c
xdoc;;cloddxxkkOOOOOOkkxkkO0KKKKKKKXXXXXXXXXXXXKXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKXXNXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKK000OOkxxxdolc:;
000Oxc;:loddxxkOO000OOkkkk00KKKKKXXXKXXXXXXXXXXKKXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKK00OOkkkkxddolc
00000Oo;:loddxkOO000OOkkO00KKKKKKKXKKXXKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKK00OkkOOkxxddol
0O0000Oo;:lodxkOOOOOOOOO0KKKKKKKKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKXXNXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK00KKKKKKKKKK000OkkOOkkxxdol
kOOO000Od::loxxkOOOkOO00KKKKKK0000KKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKXXNXXXXXXXXXXXXXXXXXXXXXXKKKXXXKKKKKKKKKKKKK00KKKK00000000OkkkOOOOkkxoc
,;;::cokOo:cldxxxxkO00KKKKK0OOOOOO00KKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKXXNXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKKK0000000OOkkOOOOOOkxoc
''....'ckOo:cloodxO00KK00OOkkkkOOOO0KXXXXXXXXXXXXXXXNNNNNNNXXXXXXXXXKKKKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKKKKKKKKKKKK0000000OOkkO00OOkxdoc
......'ckOOd:cldk000000OkkkkkkkkOOO0XXXXXXXXXXXXXNNNNNNNNNNXXXXXXXXXXXXXKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKKK0KK000000000000OOkOOOOkkxoc;
'''..';lkO0Od:ok00000OkkxxxddxkOO00KXXXXNNNNNNNNNNNNNNNNNNXXXXXXXXXXXXXKKKKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK0000OOOO0000000OOOkkOkkxdc'.
.....,:lkOO0Oxk00000OkkxodxxxkOOO0KXXXXXNNNNNNNNNNNNNNNNNNXXXXXXXXXXKKKKKKKKKKK0KKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXKXKKKKKKKKKK0OOkkkkkkOO000OOOOkkkxdc.  
''..';:lkOOOOOO00000OkkxxxkkO000KKXXXNNNNNNNNNNNNNNNNNNNNNXXXXXXXXK00KKKKKKKKKKKKKK00KXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKK0OOkkkkkkkkkOO0OOOkkxd:.   
''..;::okOOOOO0000K0OOOOOO00000KXXXNNNNNNNNNNNNNNNNNNNNNNXXXXXXK000KXXXKKKKKKKKKKKKKK00KXXXXXXXXXNXXXNNXXXXXXXXXXXXXXXXXKKK00OOOkxxdxxxkkO00OOkxc.    
'..':::okOOOkO000KKKK0OO0000KKXXXNNNNNNNNNNNNNNNNNNNNNNXXXXKKKOO0KKKKXXKKKKKKKKKKKKKKK000KXXXXXXXXNNNNNXXNXXXXXXXXXXXXXXXXKK0OOOkkxxdoodxxkO0OOkl.    
'..;:::okOOkkOO00KKKKKKKKKKXXXNNNNNNNNNNNNNNNNNNNNXXXXXXKKK0kkO0KKKKXXKKKKKKKKKKXXXXXXXK0O0KKXXXXXNNNNNNNXXXXXXXXXXXXXXXXXXKK0OOOOOkkdodxxxOO0OOkc.   
..,:c:cokOOkkOO00KKKKXXXXXXNNNNNNNNNNNNNNNNXXXXXXXXXXXKK0OkkO0KKKXXXXXXXKKKKKKKKKKXXXXXXK0OkOKXXXXXXNNNNNNNNNNNNNNNNXXXXXXXXKK0OOOOOkkkxxxxkOOOOOx;   
.';:cccoxOOxxkO000KKKXXXXXNNNNNNNNNXXXXXXXXXXXXXXXXKKK0OkkO0KKKXXXXXXXXXXXKKKKKKKKKXXXXKKKKOxk0KXXXXXNNNNNNNNNNNNNNNNNNNNXXXXKK00000OOOOkxkkOOOOOOo.  
.,::::coxOOkxxkO000KKKKXXXXXXXXXXXXXXXXXXXXXXXXXKKK0OkkO0KKXXXXXXXXXXXXXXXXXXXKKKKXXXXXXKXKK0kxk0KXXXXXNNNNNNNNNNNNNNNNNNNNXXXXKKK000OOOkkOOOOOOOOx;  
';:cc:ldxxkxddkOOO00KKKKKXXXXXXXXXXXXXXXKKKKKKKK00Okk0KKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKK0kkk0KXXXXXXXNNNXNNNNNNNNNNNNNXXXXXKKK000OOOOOOOOOOkkc. 
;::::coxddddoodxkOOO000KKKKKKKXXXKKKKKKKKKK0000Okkk0KXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKK0kkO0KXXXXXXXXXXXXNNNNNNNNNXXXXXXKKKK000000OOOOOkkc. 
:::::cddddddoooodxkkOO0000KKKKKKKKKK0000000OOkxxO0KXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXK0OOO0KKKXXXXXXXXXXXXXXXXXXXXXXKKKKKK00000OOOOkkx:. 
:::::ldddddddoooloddxkkkOOO00000000OOOOOOkxxxk0KKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXK0OOO0KKKKKKXXXXXXXXXXXXXXKKKKKKK00000OOOkkkxo'  
;;;;;lddddddooooolllloddxxkkkkkkkkkkxxxdxxkO0KKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXK0OOOO0KKKKKKKKKKKKKKKKKKKKK00000OOOOkkxxd;...
,,;;;oxddddddoooooolcccccllllooooodddxxkO00KKKKKKXXXXXXXXXXXXXXXXXXXNNXXNXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXK0OkkO0000000KK0OOO00000000OOOOkkkxxdo,....
,,,,:oxddddddooooooc:ccllooooodddxxkkkkkOO00KKKKKKKXXXXXXXKKKKKKKXXKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXK0OkkkkOOOOOOOkOOOOOOOOOOkkkxxxdo:'.....
,,'':ddddddddodooooc:clodxxkOOO00000OOOOOO000KKKK0000000000KKKKKKKKKKKKKKKKKKKKKKKKKXXXXXXXXXXXKKKKXXXXXXXXXXXXKKK0Okxxxxkkkkkkkkkkkxxxxxdool:'.......
,.  ;dddddddddddoool:cloddxkkOO00000000OOOOOOOOO000KKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKXXXXXXKKKKKK0Okxdollloooooooolllc:;'..........
   .:dddddddddddoool::clodxkkOO000000000OOOOOO00KKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKKKKKK000000Okxdolccc::::::::;'.......',:lo
   .:odddddddddddddoc:clodxxkkOOO0000000OOO00000KKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKK000000000000OOOkkxxxddoolllllc;.',;:codxO000
   .:lodddddddddddddl::loddxxkkkkkOOOOOOOOOOOO0000KKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKKKKKKK00000000OOOOOkkxxddddooooooooodxkO00000KKK
   .:cloddddddddddddo::coddxxxkkkkkkOOOOOOOOO0000KKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKKKKKKK000000OOOOOOOOOkkkxxddddooodxkkOOOOO0000KKKKKK
   .;:clooddddddddddl:;:coddxxkkkOOOOOOOOOOO00000KKKKKXKXXXXXXXXXXXXXXXKKKKKKKKKKKXXXXXXXNXXXXXXXKKKKKK000OOOOkkkkkxkkkxxxxddooodxkkOOOO00000000000000
   .,;:cllooodddddddo:;::coddxkkkOOOOOOOOOOOOOO0000000000KKKKKKKKKKKKKKKKKKKKK0000KKKKKKKXXXXXXXXXXKKK0000OOkkkxxxdddddddddddodxkOOOOO00KKKK0KKKK00000
  .'',,;:cllooooddddo:;::clodxxkkkOOOOOOOOOOOO00000000000KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK00000000000000OOkkkkxxxxdddddddddxkOOOO00KKKKKKKKKKKKKKKKK
  .'''',,;:cclloooooo:;:clooddxxxkkkkkOOOOOOO0000000KKKKKKKKKKKKKKKK000000OkkkO0KKKKKKKKKKKKKKKK000OOOOOkkkkkkkxxxdddddddddxxkOOOO0KKKKKKKKKKKKKKKKKKK
  .''..'',;::ccllloolc:ccloodddxxxkkkkOOOO0000000KKKKKKKKKKKKKKKKKKKKK000OkxxkO000KKKKKKKKKKKKKK00000OOOkxxxddddddddoooooodkOOOOO0KKKKKKKKKKKKKKKKKKKK
  .''...'',;;::cclllc:ccllooddxxxkkkkOOOO000000KKKKKKKKKKKXXXXXXXKXXKKKKKKKKKKKKKKKXXXXXXXXXXKKKK000OOOOkkxxxxdoooollllodxkkOOOO0KKKKXXXXXKKKKKKKKKKKK
 .'''....'',;;::cccccclllooddxxxkkkkkOOOO00000KKKKKKKKKKKKKXXXXXXXXXXXXXKKKKKKXKKXXXXXXXXXXXXXKKKK000OOkkxxxddooollloddxkkOOOOO0KKKXXXXXXKKKKKKKKKXXXX
 .'''....'',,;;::cccclooodddxxxkkkkkOOOO00000KKKKKKKKKKKKKKXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXKKK000OOkxxddoollodxxxkkkkOOOOO0KKKKXXXXXXKKKKKXKKXXXXX
..''.....'',,,;::clloodddddddxxxkkkkOOOOO0000KKKKKKKKKKKKXXXXXXXXXXXXXXXXXKKKKXXXXXXXXXXXXXXXXKKK000OkkxxddoooodkOkkxkkOOO00OOKKKKXXXXXXKKKKKKXXXXXKK0
xo;'.....'',,;:clooodddddddxxxxxkkkkkOOOO00000KKKKKKKKKKKXXXXXXXXXXXXXXXXXKKXXXXXXXXXXXXXXXXKKKK00OOkxxxdddxxkkOOkkxkkkO0KK0O0KKKKXXXXKKKKKKKXXXXXK0Ok
Od;'.....'',;cloooddddddddxxxxxkkkkkkOOOOO0000KKKKKKKKKKKKKKKKXXKKKKKKKKKKKKKKKKKKKKXXXXXXXKKK00OOkkxxxxkkkkkOOOkkkkkkO00K0OO0KKKXXXXKKKXKKKKXXKKK0Okk
xoc,'....',:looodddddxxxxxxxxxkkkkkkkOOOOO00000KKKKKKKKKKKKKKKKKKKKKKKKKKKKXKKKKKKKXXXXXXXKKK00OkkkkkkOOkkkO00OOkkkkkO00000O0KKKXXXXXKKKXXXXKKKK00Okxx
xxxdl;,',;cloodddddxxxxxxxxxxxkkkkkOOkOOOO000000KKKKKKKKKKKKKKKKKKKKKKKK0KK000KKKKKKKKKKK00OOOOOOkkOOOOkkkO00OOkkkkOO00000OO0KKKXXXXKKKKXXXKKKKK0Okkd:
kkxxxddoodooddddxxxxxxxxxxxxkkkkkkkkOOOOOOO0000000KKKKKKKKKKKKKKKXXXXKKOxOOOOOOOO0000000OOOOO0000OOOOOkkkO000OOkkOOO0000OOOO0KKXXXXXKKKKKXXKKKKK0OOx:.
kkkkxxxxxxxxxxxxxxxxxxxxxxxxxxkkkkkkkOOOOOOO000000KKKKKKKKKKKKXXXXXXKKKOxxOOOOOOOOOOOOOOO000KKK00OOOOkkkO0000OOkOO00000OOOO0KKKKXKKKKKKKXXXXKKK0OOkl..
OOOkkkxxxxxxxxxxxxxxxxxxxxxxxxkkkkkkkkkOOOOOO000KKKKKKKKKKKKXXXXXKKKKKK0kxxxxkOOO0000000000KKKK00kxxxxkO00000OkOO00000OOO00000KKKKKKKKKXXXXKKKK0OOx;..
000OOkkxxxxxxkkkkxxxxkkkkkkkxxxxxxkkkkkkkOOO00000000KKKKKKKKKKK0000000OO0OkxxdxxkOOOOOOOOOOO00OOkxddxkOO000OkkOO000OOOO00000000KKKKKKKKXXXXXKK000Oo;;l
000000OkxxxxxxxkkkkkkxxkOOOkkxkkkkkkkkkkkOOOOOOkkkkkkOOO000000OOOOOOkkxxdxxkkxxdddddxxxxxxddolcccccoxOO00OOkkOOOO00OOO000000KKKKKKKKKKXXXXXKKK000xclxk
0000O000OkkxxxkkkkkkkkkxkkOkkkkOOOOOOkkkkkkkkkkkkkxxdddxxOkxkkkddxxdddollloddxxxddooooolllc::;;;;;;lkO00OkkkOOO0000OOKK0000KKXKKKKKKKKKXXXXKKK00kookOO
OO000OOOOO0OkkkkkkkkkkOOkkkkxkkkOOOOOOOOOOOOkkOkkdollloddddoddoooddddoooollloddxxxxxxxxdddolcc:;;;:okOOOkOOOO00000OO0K000KKKKKKKKKKKKKKXXXKKK00kddOOOO
OOO0000OOOOOOOOkkkkxkkkkOOkxxxxxkkOOOkkkkkkkkkxdoc::clcllloooooddddoollllcccloooodddxxxxddooc:;;,,:dOOkkkOOO0000OOO0K0O0KKKXKK0KKKKKKKXXXKKKK0OddOOOOx
OkkkO0000OOOOOOOOOOkkkkxxkkkxxxxxxxxxxxxxxddollcccccclolllloolooooolcc:cccccloollodddoddoolc:,,,,,lkkkOOOO0000OkkOK0000KKKKKKK0KKKKXKKKKKKKK0OdxOOOOxo
K0kkkOO000OOOOOOOOOOOkOkxxkkkxdlcclcclllclllllloddddoooooolllllllloolccccloooollooodoodolllc:;,''cxkkOOkO0000OOk0K0000KKKKKKKK0KKKKKKKKKKKKKOxdOOOOkdo
KKKOkkkkOOOOOOOkOOOOOkOOkxxxxkxddoooooodddddoddxxddddddddddolllllloolllclllllllloooooooooolc:;,';dkxOOkk0K0OOOO0K0000KKKKKKKKKKKKKKKKKKKKK0OddkOOOkxoo
0KKK0OOkkkOOOOOOkkOOOOOOkkkkkkxxxxxxxxxddooooooooodddddddddooooolloolllcclllllllooollododddl:,',lxkk0OkO00OkkO0000O0KK00KKKKKKKKKKKKKKKKK0OdokOOOOxdoo
00000000OOkOOOOOOkkkO0O0OOkxkkkxxxxxxddoolllllllodddodooododdddollclcccclooooooooollodddddoc;,,cxkkO0Ok000OkkO000O00K0O000KKKKKKKKKKKKKK0OdoxOOOOkdooo
KK00O0KK000OOOkkO0OkkkkOOOOkxkkkkkxxddddoolcccccccooloollllllllllc:cc:ccllllloolllooollloolc;';okOO00Ok0K0OkO000OO000000K0KKKK000KKK00K0OdoxOOOOkxdooo
K0000O0000000OOkkkOOOkkkkkkOkkkO0OOkxddddollcccc:cclllllccccccccc:::c:::cllollllloooolllllc:,,lkO0000Ok00OOO0K000000000KK000K000KK00000OoldOOOOOxdoooo
K0000OOO00000OOOOkkkOOOkkkkkOOkkO00Okxxddoolcc::::cccccccc::::cc:::::;;;;::cclllooooollccc;,;lxO00KKKOkOOOO0KK000000000KK0000O00KK0000koldOOOOOkxdoool
K000000OO00000OOOOOkkOOOOxxkkOOkkO0000Okxdolc::;;;;:::cc:::;;;;;:::::ccccccccccccclcccllc:;:okOO0KKKKOdkOO0KKKK0OO000KKK000OOO0KKK000kolxkOOOOOkdooool
KK0000000OO0OOOOOOOOkkOOOOkxkkOOxkO0000OOkxdoc:;,,,;,;;;;;;;;;::::cclllloollllllollcclcc:,cdkO00KKKK0ddkO0KKKKKOkO00KKKK0OkkO0KKK00OxooxkOOO0Okxdooool
K0000000000OOOOOOkkkOkkOOOOOkxkkxxO0KKK000Okkxdc,'''',,,,,,;;:::::loooolllccc:::::c::c:;,:xkO00KKKK0xoxO0KKKKK0kkO00KKK0Okk00KKK0OkoldkkOOO00Okdoooool
K0000000000OO000OOkkkkkkO000OOkkdlok0KKKK00OOkkxo:'',,;,,,;;:::cccllllllllc:::;;;,,,,,,';dkOO00KKKKkdkO00KKKK0kxO00KKK0xxO0KKKK00xloxkkOOOO00Oxddooool
000000OOOOOO000000OkxkkOO00000OOkd::dO0KKKK0OOOkkxo:;;::::::cccloolllccccccc:::;;,,,,'.,lxkkO00KK0kxkO00KKKKKkdk00KKKOxxO00KKK0OdlokkOOOO0000kddoooool
000000OOkOOOOOO000OOkxxkOO000000Okxl:lxO0KK000OOkkxxlcllloodddoooddoloddddodoolc:c::;'.cxkkOO0000kxkO00KKKKKOxkO00K0kdk00000K0OdlokkOOO00000Oxddoooool
0000000OkkkkkOO00000OOkxxkOO000K0OOkxoloxO000OOOOkkkxdoodxxxxdddddooodxkkxxkkkkxooolc,;okOOO0000kxkO0KKKKXKOkO00000kdxO000000OdldkkOOOO00000Oxddoooooo
00000000OkxxxkOO000000OkxdxkO0000000OkxoloxOOOOOOkkkkkdollllooloooooodxxxxkkOOOOkxdol;ckkOOO000OxxOO0KKKKK0kO00KK0OdxO00000OOdlokkOOOOO00000kdddoooooo
kO0000000OkkxdxkO000000OOxxddkO000K00OOkxoloxOOOOO00OOkdc::;:odxxdoooddxxxkkkOOO0OkxocoOO00000OxxkOO000KK0kk00000OddO0KKKK0OxlokkkOO000000K0kddooooooo
xxkO0000000Okdooxk000000OxxxocokO0KK00OOOkxllokOO0000OOkoccccoxxxkxxdoddddxxxkkkOkxkdcd0000KK0xxkOOO000K0kkO0OOOkddk0KKKK0OxloxkkOO000000KK0xddooooooo
Okxxk0000KK0Okdc:ldk00OOOkkkkdclxO00K00OOkkxdooxO00000Okxoccooodddxxxdooooddddxxxxdxocx000KKKOxxkkkO00O0OkO0Okkxddk000KK0OdclxkkOOO00000KKKOxdoooooooo
OOOkdk00K00000Oxl,;oxxO0000OOkdc:dO0000Okkkkkxolok0000Okxdlccccododxkxddddddddddddddllk000KKKkxkkkOOOO0OkOOOOkxdxO00000OOd:cxkkOOOO00000KKKOxdoooooooo
OOOOkdxO0000000Oxl;;cxO00000OOkxc;lx0000OOkkkkxdloxOOOOkkxdlcc::oooodddooodddxddoooocokOO0000xxOOOOOOOOkxkOkkxxxOO00K00ko;:dkkkOOO000000KKKOxdoooooooo
0OOOOkdxOO0000OOkko:;oxOO00OOkkkxc,:dOOOOOOOkkkkxooxkOOkkkxdoll:;coooodddooddddoooolcdkkOOO0kdx000O00OkdxOOkkxkOO000K0ko:;oxkkkOOO000000KKKOxddooooooo
0OOOOOkdxkOOOOOOkxxo:;lxkOOOOkkxxd:.,okOO0OOkOOOOxoldkkkkkkxdoll:;cddddxxxxddddooooclxOOOOOOxdO00000OkdoxOkkxkO0KKK0Okl::cdxkkkOOO000000KKKOxdoooooooo
00OOOOOkdxkkkkkOkkxxo:;ldxkkkkkxxxd;.'ckOOOOO000OOxlldxkOOkxxdool:;coodddxxxxxxxddoclkOOOO00xxO00000OxodkkkxkO0KK00Oxoc:coxkkkOOOOO00000KKKOxdoooooooo
0OOOOOOOxddkkkOOOOOkxo:;cdxxxxkkkxxo;..:xO000K00OOkxooxkkkOkxxdddolccclooddddxxxxxdooxkO0OOOxk00000OOdoxkkkk0KK0OkkxdlccldxkkkOOOOO00000KKK0xdoooooooo
OOOOOOOOOxddkOO0000Okxo:;coxkkkkkkkxl:..;dO0KKK00OOOxoodxk0OkkxdddddolccllooooooddoclkO0K0OxdkOOOOOOxddkkkOO00OdodxxxdoodxkkkkOOOOO00000K0K0kdoooooooo
OOOOOOOOOkkxdkO00000Okxdc;coxkOOOOOkdo:'.;oO0000000OkdoodkOOOkxdoolodddollodddddxxdllk000KOddkOOOO0OxdkOOOO00Od:lxxkkxxxxxkkkkOOOOOO00000000kdoooooooo
OOOOOOOOOkkkxdxOO00OOkkxdc;:oxkkOOOkxdl:,',lkO0000OOkkdlloxOOkxdoollodddocldddxxxxxlcxO000xlokkkkOOkxk0000000xc:oxxkkkkkkxkkkkOOOOOOO00000K0Oxoooooooo
OOOOOOOOOOOkkxodkkOOOOOkkxl;:odxkkkkkxol:,,,:dOOOOOkkxdollodxxdoooollodxdoc:ldxddddoldOOOkc:dkkOkOkxxO0KK000kl;cdxxkkkkkkkkkkkkOOOOOO00000000xdooooooo
OOOOOOOOOOOOkkxodkkOOOO0Okxl:codxkkkkxdol;,;,:dkkkkkxxxddoooddddolol::codoc;coddodddxxkkkdccxkOOOkxxO00000Okl:coxxxkkkkkkkkkkkkkOOOOOO0000000kdooooooo
OOOOOOOOOOOOOkkxooxkkO00Okkxo:codxxkkxdool;,;,:dxxkkkkxddooloooooooocccclc;:cooodddxxxxxkxloxkkkkdxO0KK00Okl::ldxxxkkkkkkkkkkkkkkOOOOOO000000Oxdoooooo
OOOOOOOOOOOOOkkkxdldkkkkOOOkxocloddxxkxdddo:;;;cdxkkkxxxxdooloooodolcc:clcclloodddxxxxxxkdodkkOkddk0KK00Okoc:codxxxkkkkkkkkkkkkkkOOOOOOO000000Oxooooll
OOOOOOOOOOOOOkkkkxdloxkkO000kxocloddxxkxdddo:;:;cdxxxkOkxxdooooooolc::::::clloooodxxxxxkkdodkkkxdxOKK0OOkocccodxxxxxkkkkkkkkkkkkkkOOOOOOO00000Okdooool
OOOOOOOOOOOOOkkkkkkxdodxkO00Okxlloddxxxxxddol:;,;cdxxkkkxkxoloooooollllc:ccccllooddxxxkxxdlokkkkxxxxkkkxdollodxxxxxxkkkkkkkkkkkkkkOOOOOOOO00000Oxdoool
OOOOOOOOOOOOOOOkkkkkkxddxxkkkkxxoldxxxxkkkdddlc;,,:dxkkkkkxolooollllllllccccclloodxxxxxxxdodkOOOOxoloxkxxxxxxxxxxxxxkkkkkkkkkkkkkkkOOOOOOO000000kxoooo
OOOOOOOOOOOOOOOOkkkkkkkkkxxxkkxxdooxxxkOOkxdddool:;:oxkkkxdooololcccllllccccclloddxxxxxkxxxxxkOOkddxxkkkkkkkkxxkkxxxkkkkkkkkkkkkkkkOOOOOOOOOO000Okdooo
OOOOOOOOOOOOOOOOOkkkkkkkkkkkxxxxxxooxkkkOOkkxxxdddlcclooooloooooolcc:clccccccclooddxxkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkOkkOOOOOOOOO00Okdoo
OOOOOOOOOOOOOOOOOkkkkkkkkkkkkxkkkxxdodxkOOOOkxxxxxxdddddddoooooollc:,;;;:cccclloddxxxkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkOOOOOOOOO0OOkdo
OOOOOOOOOOOOOOOOOkkkkkkkkkkkkkkkkkkxxxxxkkkkxxxxkkkxxxxxxxxddoooool:'.',:ccclloddxxxxxkkkkkkkkkOkkkkkkOkkOOkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkOOOOOOOOOOko
0OOOOOOOOOOOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkkkkxkkkkkkxxxxxddddooool:'..,:cllooddxxxkkkkkkkkkkkOOkkkkkkOOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkkkkkOOOOOOOOOOk
OOOOOOOOOOOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkOkkkkkkOOkkkkxxxxxdddddool,..,cloodddxxxxkkkkkkkkkkOOOkkkkkkOOOOOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkkkOOOOOOOOOO
OOOOOOOOOOOOOOOOOkkkkkkkkkkxxkkkkkkkkkkkkOOkkkkkkkOkkkkkxxxxxxddddol,.':loddxxxxxkkkkkOOkkkkOOOOOOkOOOOOOOOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkOOOOO
OOOOOOOOOOOOOOkkkkkkkkkkkkkkkxxkkxxkkkOOOOOOkkkkkOOOkkkkkkkkkxxxddol;';lodxxxxxkkkkkOOOOOOOOOOOOOOOOOOOOOOOOOOOOkkkkkkkkkkxxkkkkxxkkkxkkkkkkkkkkkkOOOO
OOOOOOOOOkkkOkkkkkkkkkkkkkkxxxxxxxkkkOOkkOOOOOkkOOOOOkkkkkkkkkxxxddl;,codxxxxkkkkOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOkkkkkkkkkxxxxkkkxxxxxxxxxkkkkkkkkkkkkk
OOkkkkkkkkkkkkkkkkkkxkkkxxxxxxxxxxkkkOOkkOOOOOkkOOOOOkkkkkkkkkkxxxdc;:ldxxxkkkkOOOOOOO000O00000OOOOOOOOOOOOOOOOOOkkkkkkkkxxxxxxxxxxxxxxxxxxxxxxkkkkkkk
kkkkkkkkkkkkkkkxxxxxxxxxxxxxxxxxxxkkkkkkkOOOOkkkOOkOOOOOkkkkkkkkxxo:;codxkkkkkkOOOOO00000000000OOOOOOOOOOOOOOOOOOkkkkkkkkkxxxxxxxxxxxxxxxddxxxxxxxxxxx
kkkkkkkkkkkkkxxxxxxxxxxxxddddxxxxxxxkkkkkkkkkkkOOOOkkkkkkkkkkkxxxdl;:odxxkkkkOOOOO000000000000OOOOkkOOOOOOOOkkkkkOOkkkkkkkkxxxxxddddddddddddddddddddxx
kkkkkkkxxxxxxxxxxxxxxdddddddxxxxxxxxkkkkkkkkkkOOOOkkkOOkkkkkkxxxxo::ldxxkkkOOOOOO00O0000000000OOOOkkOOkkkkkkkkkkkkkkkkkkkkkxxxxxxddddooooooooooooooodd
kkkkxxxxxxxxxxxdddddddddddddxxxdxxxxxxxxxkkkkkkkkkkkkkkkkkkkxxxdo::codxxkkOOOOOOOOOO0000000000OOOOOkkkkkkkkkkkkkkkkkkkkkkkxxxxxxxxxdddoooooooooolllloo
xxxxxxxxxxdddddddddddddddddddddddxxxxxxxxkkkkkkkkkkkkkkkkkkxxxdc'':lodxxkkkkkOOOOOOOO000000OOOOOOOOkkkkkkkkkkkkkkkkkkkkkkkkkkkkxxxxxxxxddddoooolllllcc
xdddddddddoooooooodddddddddddodddddddxxxxxkkkkkkkkkkkkkxxxxddol:,',:lddxxkkkkkOOOOOOOO0000OOOOOOOOkkkkxxkkkkkkkkkkkkkkkkkkkkkkkkkxxxxxxxxxddddooollllc
dddddooooooooooooodddoooooooooooodddddxxxxxxxxxxxxxxxxxxddoooolllc:;:cldxxkkkkkkOOOOOOOOOOOOOOOOOkkkkxxxxxkkkkkkkkkkkkkkkkkkkkkkkkkkkxxxxxxxxddddoooll
ooooollllllloooodoooollllllllllllooodddddxxxxxxxxxxdddooooooooooooolc::codxxxxkkkkOOOOOOOOOOOOOOOkkkkxxxxxxkkkkkkkkkkkkkkkkkkkkkkkkkkkxxxxxxxxdddoooo*/
?>