<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Statistique;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatistiquesController extends Controller
{
    
    /**
     * @Route("/gameOver", name="game_over")
     */
    public function gameOver(Request $request)
    {
        $players = $request->request->get('players');
        $winners = $request->request->get('winners');
        $statistique = new Statistique();
        switch(count($players))
        {
            case 2:
                $statistique->setJ1($this->getNameIA($players[0][5]));
                $statistique->setJ2($this->getNameIA($players[1][5]));
                break;
            case 3:
                $statistique->setJ1($this->getNameIA($players[0][5]));
                $statistique->setJ2($this->getNameIA($players[1][5]));
                $statistique->setJ3($this->getNameIA($players[2][5]));
                break;
            case 4:
                $statistique->setJ1($this->getNameIA($players[0][5]));
                $statistique->setJ2($this->getNameIA($players[1][5]));
                $statistique->setJ3($this->getNameIA($players[2][5]));
                $statistique->setJ4($this->getNameIA($players[3][5]));
                break;
        }
        $wins = '';
        if(count($winners)>1)
        {
            $wins = 'Egalité';
        }
        else
        {
            $wins = 'J'.($winners[0]+1);
        }
        $statistique->setWinner($wins);
        $em = $this->getDoctrine()->getManager();
        $em->persist($statistique);
        $em->flush();
        return new Response();
    }
    
    public function getNameIA($ia)
    {
        switch ($ia)
        {
            case 0:
                return 'Random';
            case 1:
                return 'Aggressive';
            case 2:
                return 'Min-Max';
            default:
                return 'IA inconnue';
        }
    }
    
}
