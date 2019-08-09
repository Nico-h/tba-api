<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Traits\ObjectFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController {

    use ObjectFactory;

    /**
     * @route("/player/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function getPlayerById($id) {

        $player = $this->getDoctrine()->getRepository(Player::class)->find($id);
        $lastFiveGames = $this->getDoctrine()->getRepository(Game::class)->getPlayerGames($id);
        $historyGames = $this->getDoctrine()->getRepository(Game::class)->getPlayerGames($id, 50);

        return new JsonResponse(
            $this->buildPlayerArray(
                $player,
                $lastFiveGames,
                $this->getPlayerVictories($player, $lastFiveGames),
                $this->getPlayerStatsArea($player, $historyGames)),
            200);
    }

    /**
     * @param Player $player
     * @param Game[] $games
     * @return int
     */
    private function getPlayerVictories($player, $games) {

        $victories = 0;
        foreach ($games as $game) {
            if($this->hasPlayerWon($player->getId(), $game->getPlayerWon()->getId())) {
                $victories++;
            }
        }

        return $victories;
    }

    /**
     * @param Player $player
     * @param Game[] $games
     * @return mixed
     */
    private function getPlayerStatsArea($player, $games) {

        $area['indoor'] = 0;
        $area['hard'] = 0;
        $area['clay'] = 0;
        $area['grass'] = 0;

        foreach ($games as $game) {
            if($this->hasPlayerWon($player->getId(), $game->getPlayerWon()->getId())) {
                switch ($game->getTournament()->getArea()) {
                    case 'INDOOR': $area['indoor']++; break;
                    case 'HARD': $area['hard']++; break;
                    case 'CLAY': $area['clay']++; break;
                    case 'GRASS': $area['grass']++; break;
                }
            }
        }

        return $area;
    }

    /**
     * @param int $playerId
     * @param int $playerWonId
     * @return bool
     */
    private function hasPlayerWon($playerId, $playerWonId) {
        return $playerId == $playerWonId;
    }

    /**
     * @route("/player", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addPlayer(Request $request) {

        $playerName = $request->get("name");

        $entityManager = $this->getDoctrine()->getManager();

        $existingPlayer = $this->getDoctrine()->getRepository(Player::class)->findOneBy(["name" => $playerName]);
        if(!$existingPlayer){
            $player = new Player();
            $player->setName($playerName);

            $entityManager->persist($player);
            $entityManager->flush();

            return new JsonResponse("Player saved", 201);
        } else {
            return new JsonResponse("Player already exists", 200);
        }
    }
}