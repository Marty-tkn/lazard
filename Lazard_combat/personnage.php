<?php
class personnage
{
    public $nom;
    public $vie;
    public $atk;
    public $stam;
    public $initiative;
    public $soin;
    public $estPNJ;

    public function __construct($nom, $vie = 100, $estPNJ = true, $stam = 100)
    {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->estPNJ = $estPNJ;
        $this->stam = $stam;
    }
    // @commande Fonction qui gére les input des actions possible par le joueur , ou par le monstre si PNJ. 
    public function commande($combattant2)
    {
        if ($this->estPNJ) {
            $action = 1;
        } else {
            echo "A vous de jouez Héros !", PHP_EOL;
            echo "1: Attaquer  2: Compétences", PHP_EOL;
            $action=readline();
            }
            switch ($action) {
                case 1:
                    $this->attaque($combattant2);
                    break;
                case 2:
                    $comp = 0;
                while($comp<=0 || $comp >=5){
                    echo '1 : Attaque lourde     2 : Soin'.PHP_EOL.'3 : Défense            4 : Revenir'.PHP_EOL;
                    $comp = readline();
                }
                switch($comp){
                    case 1:
                        $this->heavyAtk($combattant2);
                    break;

                    case 2:
                        $this->soin();
                    break;

                    case 3:
                        $this->def=3;

                    break;

                    case 4:
                        $this->commande($combattant2);
                }

            }
    }

    protected function lancer($min, $max)
    {
        return mt_rand($min, $max);
    }

    protected function attaque($combattant2)
    {
        $chanceAction = $this->lancer(1, 6);
        if ($chanceAction == 6) {
            $this->attaqueCritique($combattant2);
        } elseif ($chanceAction == 1) {
            $this->attaqueLoupee();
        } else {
            $this->attaqueNormal($combattant2);
        }
        $this->stam += 20;
            if ($this->stam > 100){
                $this->stam = 100;
            }
    }

    protected function attaqueNormal($combattant2)
    {
        $this->atk = $this->lancer(2, 5);
        $combattant2->vie = ($combattant2->vie) - ($this->atk);
        echo  "Attaque lancé !", PHP_EOL;
    }

    protected function attaqueCritique($combattant2)
    {
        $this->atk = $this->lancer(2, 5);
        $combattant2->vie = ($combattant2->vie) - ($this->atk + 10);
        echo  "ATTAQUE CRITIQUE !!", PHP_EOL;
    }

    protected function attaqueLoupee()
    {
        echo  "Attaque loupé LOSER !", PHP_EOL;
    }
    protected function soin()
    {
        $soin = $this->lancer(1, 4);
        $this->vie = min(100, $this->vie + $soin);
        echo  "Vous vous êtes soigné de " . $soin . " points de vie", PHP_EOL;
        $this->stam -= 10;
    }

    protected function heavyAtk($combattant2)
    {
        $randDice = $this->lancer(1,6);
        $this->atk = mt_rand(9,12);

        if ($this->stam - 60 >= 0)
        {
            switch ($randDice)
            {
            case 6 : // attaque crit'
                $combattant2->vie -= $this->atk + 10;
                echo 'ATTAQUE CRITIQUE !!'.PHP_EOL;
            break;

            case 1 : // attaque loupée
                echo 'Attaque loupée LOSER !!'.PHP_EOL;
            break;

            default :
                $combattant2->vie -= $this->atk;
                echo 'Attaque lourde lancée !'.PHP_EOL;
            }
            $this->stam -= 60;
        }
        else {
            echo ' Vous n\'avez pas assez de stamina, attaque lourde impossible!'.PHP_EOL;
            $this->commande($combattant2);
        }
        
    }





    public function lifeCount($combattant2)
    {
        echo 'Le', ' ', $combattant2->nom, ' a ', $combattant2->vie, ' ', 'HP.', PHP_EOL, PHP_EOL;
    }

    public function estVivant()
    {
        return $this->vie > 0;
    }
    public function estMort()
    {
        if ($this->vie < 0) {
            $this->vie = 0;
        }
    }
}
