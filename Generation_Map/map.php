<?php

require "room.php";

class Map{
    protected $_mapping;
    private $_size;
    public $PersoY = 0;
    public $PersoI = 0;
    
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
    //Fonction pour afficher la carte ROOM par ROOM pour le joueur
   
    public function affichageJoueur(){
        $visite = array();
        
        $i=0;
        foreach($this->mappings as $hori){
            $y=0;
            foreach($hori as $verti){
                //Définie le symbole sur le "TERMINAL" ----------------------------------
                if($this->mappings[$i][$y]->_type==0){
                    echo '   ';
                }elseif($this->mappings[$i][$y]->_type == Room::START){
                    if($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                    }else{
                        echo '[✪]';
                    }
                }elseif($this->mappings[$i][$y]->_type == Room::ROOM){
                    if($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[ ]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }elseif($this->mappings[$i][$y]->_type == Room::BOSS){
                    if($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[☠]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_TREASURE){
                    if($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[€]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_MONSTER) {
                    if($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[♀]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }elseif ($this->mappings[$i][$y]->_type == Room::TREASURE_MONSTER_ROOM) {
                    if($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[⁂]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }elseif ($this->mappings[$i][$y]->_type == Room::ROOM_FIRE_CAMP) {
                    if(($this->mappings[$i][$y-1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i][$y+1] == $this->mappings[$this->PersoH][$this->PersoV] || $this->mappings[$i+1][$y] == $this->mappings[$this->PersoH][$this->PersoV]) || $this->mappings[$i-1][$y] == $this->mappings[$this->PersoH][$this->PersoV] || (isset($this->visite[$i][$y]) && $this->visite[$i][$y] == true && ($i != $this->PersoH || $y != $this->PersoV))){
                        echo '[♨]';
                        
                    }elseif($i == $this->PersoH && $y == $this->PersoV){
                        echo '[▲]';
                        $this->visite[$i][$y] = true;
                    }else{
                        echo '   ';
                    }
                }
                $y++;
                $room=false;
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
        $this->PersoH = $h;
        $this->PersoV = $v;
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
        $finish = array();
        $fH = 0;
        $fV = 0;
        while($boss < $nbBoss){
            $hr = mt_rand(0, $this->_size - 1);
            $vr = mt_rand(0, $this->_size - 1);
            if (($hr > 0 && $hr < $this->_size - 1) && ($vr > 0 && $vr < $this->_size - 1 && $this->mappings[$hr][$vr]->_type == Room::WALL)) {
                if ($this->mappings[$hr + 1][$vr]->_type != 0 || $this->mappings[$hr - 1][$vr]->_type != 0 || $this->mappings[$hr][$vr + 1]->_type != 0 || $this->mappings[$hr][$vr - 1]->_type != 0) {
                    if ($this->mappings[$hr + 1][$vr]->_type != 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                        $this->finish[$fH][$fV] = $this->mappings[$hr][$vr];
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type != 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                        $this->finish[$fH][$fV] = $this->mappings[$hr][$vr];
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type != 0 && $this->mappings[$hr][$vr - 1]->_type == 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                        $this->finish[$fH][$fV] = $this->mappings[$hr][$vr];
                    }
                    if ($this->mappings[$hr + 1][$vr]->_type == 0 && $this->mappings[$hr][$vr + 1]->_type == 0 && $this->mappings[$hr - 1][$vr]->_type == 0 && $this->mappings[$hr][$vr - 1]->_type != 0) {
                        $this->mappings[$hr][$vr]->_type = Room::BOSS;
                        $boss++;
                        $this->finish[$fH][$fV] = $this->mappings[$hr][$vr];
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
?>