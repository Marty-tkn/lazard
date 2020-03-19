<?php
require_once "personnage.php";
class jeu
{
    public $victoiresHeros = 0;
    public $victoiresMechant = 0;
    public function begin($heros, $mechant,$map)
    {
        $tours = 0;
        while ($heros->estVivant()  && $mechant->estVivant()) {
            $tours = $tours + 1;
            echo 'Tours de jeu n°', $tours, ' : ', PHP_EOL;
            $heros->state();
            $heros->commande($mechant);
            $heros->checkState();
            $mechant->estMort();
            $heros->lifeCount($mechant);

            if ($mechant->estVivant() == false) {
                break;
            }
            echo 'Monstre attaque', PHP_EOL;
            $mechant->state();
            $mechant->commande($heros);
            $mechant->checkState();
            $heros->estMort();
            $mechant->lifeCount($heros);
        }

        if ($heros->estVivant($this->victoiresHeros, $this->victoiresMechant)) {
            echo 'For the EMPEROR !!';
        } else {
            echo 'GAME OVER';
        die();
        }
    }
}
