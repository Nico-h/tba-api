<?php

namespace App\Controller;

use App\Entity\Game;
use App\Traits\ObjectFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    use ObjectFactory;

    /**
     * @route("/stats/{tournamentType}/{area}/{round}/{odd}")
     * @param $tournamentType
     * @param $area
     * @param $round
     * @param $odd
     * @return JsonResponse
     */
    public function getStatsByTournamentSettings($tournamentType, $area, $round, $odd){

        $nbGames = $this->getDoctrine()->getRepository(Game::class)->getGamesByTournamentTypeAreaRoundAndOdd($tournamentType, $area, $round, $odd);
        $nbVictories = $this->getDoctrine()->getRepository(Game::class)->getVictoriesByTournamentTypeAreaRoundAndOdd($tournamentType, $area, $round, $odd);

        $gamesPlayed = (int)$nbGames[0]["1"];
        $victories = (int)$nbVictories[0]["1"];
        $ratio = $victories / $gamesPlayed;
        $amountWin = round($this->getAvgWinOddAmount($odd) * $victories - $gamesPlayed, 2);
        $amountLose = round(($gamesPlayed - $victories) * $this->getAvgLoseOddAmount($odd) - $gamesPlayed,2);

        $stats["nbGames"] = $gamesPlayed;
        $stats["nbVictories"] = $victories;
        $stats["ratio"] = $ratio;
        $stats["amountWin"] = $amountWin;
        $stats["amountLose"] = $amountLose;

        return new JsonResponse($stats, 200);
    }

    /**
     * @param float $odd
     * @return float|int
     */
    private function getAvgWinOddAmount($odd) {

        $calc = 0;
        switch ($odd) {
            case 1: $calc = 1.13;break;
            case 2: $calc = 1.23;break;
            case 3: $calc = 1.33;break;
            case 4: $calc = 1.43;break;
            case 5: $calc = 1.53;break;
            case 6: $calc = 1.63;break;
            case 7: $calc = 1.73;break;
            case 8: $calc = 1.8;break;
        }

        return $calc;
    }

    /**
     * @param float $odd
     * @return float|int
     */
    private function getAvgLoseOddAmount($odd) {

        $calc = 0;
        switch ($odd) {
            case 1: $calc = 4.1;break;
            case 2: $calc = 3.3;break;
            case 3: $calc = 2.75;break;
            case 4: $calc = 2.45;break;
            case 5: $calc = 2.2;break;
            case 6: $calc = 2.05;break;
            case 7: $calc = 1.9;break;
            case 8: $calc = 1.85;break;
        }

        return $calc;
    }
}