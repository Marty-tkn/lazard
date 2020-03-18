<?php

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