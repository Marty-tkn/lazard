-
<?php

class personnage
{
    public $name;
    public $hp;
    public $atk;
    public $armor;
    public $bonusArmor;
    public $stam;
    public $def = false;
    public $i=0;
    //stat
    public $poison = 0;
    public $etourdie = 0;


    public function __construct($name,$armor=0,$hp=100,$stam=100,$atk=10){
        $this->name = $name;
        $this->hp = $hp;
        $this->stam = $stam;
        $this->$atk = $atk;
        $this->armor = $armor;
    }

    public function attack($target){
        $rand_dice = $this->dice();
        $this->atk = 10 - $target->armor - $target->bonusArmor;
        $typeAtk = '';  
        $this->stam += 10;    
            switch($rand_dice) {
                case 1 :
                    echo 'Attaque manquée!! tu es un LOSER';
                    
                break;
                case 9:
                case 10:
                    $this->atk *= 2;
                    $typeAtk = 'CRITICAL !!!';
                default :
                    $target->hp -= $this->atk;
                    echo $typeAtk;
            }    
        if ($this->stam > 100){
            $this->stam = 100;
        }

        if ($target->hp <= 0){
            $target->hp = 0;
            $target->dead($this);
        }
    }


    public function heavyAtk($target){
        $rand_dice = $this->dice();
        $this->atk = mt_rand(25,35);
        $this->stam -= 60;
        $typeAtk='';
        switch($rand_dice) {
            
            case 10:
                $this->atk *= 2;
                $typeAtk = 'CRITICAL !!!';
            default :
                $target->hp -= $this->atk;
        }
        
        if ($target->hp <= 0){
            $target->hp = 0;
            $target->dead($this);
        } else {
        echo $typeAtk, PHP_EOL, $target->name.' à perdu '.$this->atk.' points de vie. Il lui reste '.$target->hp.' points de vie.'.PHP_EOL;
        }
    }

    public function dice(){
        $rand_dice = mt_rand(0,10);
        return $rand_dice;
    }



    public function state(){
        if($this->poison > 0 ){
            poison();
            $this->poison--;
        };
        if($this->def > 0 ){
             $this->bonusArmor = 0;
             $this->def();
             $this->def--;
        }else{
             $this->bonusArmor = 0;
        }
        if($this->etourdie > 0 ){
            etourdie();
            $this->etourdie--;
        };
    }

    public function poison(){

    }


    public function def(){
        $this->bonusArmor = round($this->armor/2);
        echo $this->bonusArmor,'BITE';
    }


    public function heal(){
        $heal = mt_rand(10,20);
        $this->stam -= 10;        
        $this->hp += $heal;
        if ($this->hp > 100){
            $this->hp = 100;
        }
        echo $this->name.' c\'est soigner de '.$heal.' points de vie. Il lui reste '.$this->hp.' points de vie.'.PHP_EOL;
    }

    public function dead($target){
        if ($this->hp<=0){
            echo $this->name.' est mort! x_x'.PHP_EOL;
            $this->restart($target);
        }
    }

    public function fight($target){

        echo PHP_EOL.'Votre héros à '.$this->hp.' points de vie et '.$this->stam.' points d\'endurance.'.PHP_EOL;
        echo PHP_EOL.'Votre adversaire à '.$target->hp.' points de vie et '.$target->stam. " points d'endurance.".PHP_EOL.PHP_EOL;

        $fight = 0;
        while($fight <= 0 || $fight >= 3){
            echo 'Pour attaquer, taper 1;'.PHP_EOL.'Pour voir les compétences, taper 2; '.PHP_EOL."" ;
            $fight = readline();
        }

        switch ($fight){
            case 1:
                $this->attack($target);
            break;
    
            case 2:
                $comp = 0;
                while($comp<=0 || $comp >=5){
                    echo '1 : Attaque lourde     2 : Soin'.PHP_EOL.'3 : Défense            4 : Revenir'.PHP_EOL;
                    $comp = readline();
                }
                switch($comp){
                    case 1:
                        $this->heavyAtk($target);
                    break;

                    case 2:
                        $this->heal();
                    break;

                    case 3:
                        $this->def=3;

                    break;

                    case 4:
                        $this->fight($target);
                }
        }
    }

    public function restart($target){
        $restart ="A";
        while($restart!="O" && $restart!="N"){
            $restart = readline("Voulez-vous rejouer?O/N ");
            $restart = strtoupper($restart);
        }
        
        switch ($restart){
            case "O":
                echo "New Fight!! ";
                $this->hp=50;
                $target->hp =50;
                $this->fight($target);
            break;

            case "N":
                echo 'A tantôt!!';
                exit();
        }
    }

}
