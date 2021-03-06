<?php

namespace Dinet\Monitoring;

class Citation
{
    private $citationList = [
        'Que la nourriture soit ton médicament et que ton médicament soit dans ta nourriture - Hippocrate',
        'Il faut manger pour vivre et non vivre pour manger - Molière',
        'De tous les arts, l\'art culinaire est celui qui nourrit le mieux son homme - Pierre Dac',
        'La force, c\'est de pouvoir casser une barre de chocolat en 4 morceaux et de n\'en manger qu\'un carré - Judith Viorst',
        'Manger est une nécessité, mais manger intelligemment est un art - La Rochefoucauld',
        'Je vis de bonne soupe, et non de beau langage - Molière',
        'De toutes les passions, la seule vraiment respectable me paraît être la gourmandise - Guy de Maupassant',
        'Une pinte de bière est un mets de roi - William Shakespeare',
    ];

    public function getCitation( $pos = -1 )
    {
        if( $pos === -1 )
        {
            return $this->citationList[rand( 0, count( $this->citationList ) -1 )];
        }
        else
        {
            return $this->citationList[$pos];
        }
    }
}
