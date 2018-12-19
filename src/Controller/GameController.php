<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Tournament;
use App\Traits\ObjectFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    use ObjectFactory;

    /**
     * @route("/game/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function getGameById($id) {

        $game = $this->getDoctrine()->getRepository(Game::class)->find($id);

        return new JsonResponse($this->buildGameArray($game));
    }

    /**
     * @route("/game", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addGame(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        $game = new Game();
        $tournament = $entityManager->getRepository(Tournament::class)->find($request->get("tournament"));
        $playerA = $entityManager->getRepository(Player::class)->find($request->get("player_a"));
        $playerB = $entityManager->getRepository(Player::class)->find($request->get("player_b"));
        $playerWon = $entityManager->getRepository(Player::class)->find($request->get("player_won"));

        $game->setTournament($tournament);
        $game->setRound($request->get("round"));
        $game->setOddA($request->get("odd_a"));
        $game->setOddB($request->get("odd_b"));
        $game->setPlayerA($playerA);
        $game->setPlayerB($playerB);
        $game->setDatetime(new \DateTime($request->get("datetime")));
        $game->setPlayerWon($playerWon);

        $entityManager->persist($game);
        $entityManager->flush();

        return new JsonResponse("Game saved", 201);
    }

}