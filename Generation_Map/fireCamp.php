<?php

class fireCamp
{

    public function regen($heros, $map)
    {
        echo 'Vous avez trouvez un feu de camp .', PHP_EOL;
        echo 'Voulez vous l\'utiliser ?', PHP_EOL;
        echo '1: Rester  2: Partir', PHP_EOL;
        $choixFC = readline();

        switch ($choixFC) {
            case 1:
                $heros->vie = 100;
                $heros->stam = 100;
                $map->mappings[$map->PersoH][$map->PersoV]->_type = 1;
                echo "Vous vous sentez d'aplomb pour reprendre votre aventure !",PHP_EOL;
                echo "Votre vie et votre endurance ont été régenérées . ",PHP_EOL;

                break;
            case 2:
                echo 'Vous partez.', PHP_EOL;
                break;
            default:
            echo 'Mauvaise commande';
            $this->regen($heros,$map);
            break;
        }
    }
}
