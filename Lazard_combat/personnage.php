<?php
class personnage
{
    public $nom;

    public $vie;
    public $atk;
    public $initiative;
    public $soin;
    public $estPNJ;

    public function __construct($nom, $vie = 100, $estPNJ = true)
    {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->estPNJ = $estPNJ;
    }
    // @commande Fonction qui gére les input des actions possible par le joueur , ou par le monstre si PNJ. 
    public function commande($combattant2)
    {
        if ($this->estPNJ) {
            $action = 1;
        } else {
            echo "A vous de jouez Héros !", PHP_EOL;
            echo "1: Attaquer  2: Soin  ", PHP_EOL;
            $action=readline();
            }
            switch ($action) {
                case 1:
                    $this->attaque($combattant2);
                    break;
                case 2:
                    $this->soin();
                default:
                    echo "Action inconnue", PHP_EOL;
                    $this->commande($combattant2);
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
        echo  "Attaque loupé LOOSER !", PHP_EOL;
    }
    public function soin()
    {
        $soin = $this->lancer(1, 4);
        $this->vie = min(100, $this->vie + $soin);
        echo  "Vous vous êtes soigné de " . $soin . " points de vie", PHP_EOL;
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
