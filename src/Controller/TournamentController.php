<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Tournament;
use App\Traits\ObjectFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    use ObjectFactory;

    /**
     * @route("/tournaments")
     * @return JsonResponse
     */
    public function getAllTournaments() {

        $tournaments = $this->getDoctrine()->getRepository(Tournament::class)->findAll();

        if(!$tournaments) {
            throw $this->createNotFoundException('No tournaments found');
        }

        $tournamentsList = [];
        foreach ($tournaments as $tournament) {
            array_push($tournamentsList, $this->buildTournamentArray($tournament));
        }

        return new JsonResponse($tournamentsList, 200);
    }

    /**
     * @route("/tournament/{id}/games")
     * @param $id
     * @return JsonResponse
     */
    public function getTournamentGames($id) {

        $tournament = $this->getDoctrine()->getRepository(Tournament::class)->find($id);

        if(!$tournament) {
            throw $this->createNotFoundException('No tournament found');
        }

        $games = $tournament->getGames();

        $gameList = [];
        foreach ($games as $game) {
            $gameList[] = $this->buildGameArray($game);
        }

        if(count($gameList) == 0) {
            throw $this->createNotFoundException('No games found');
        }

        return new JsonResponse($gameList, 200);
    }

    /**
     * @route("/tournament", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addTournament(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        $tournament = new Tournament();
        $tournament->setName($request->get("name"));
        $tournament->setType($request->get("type"));
        $tournament->setArea($request->get("area"));

        $entityManager->persist($tournament);
        $entityManager->flush();

        return new JsonResponse("Tournament saved", 201);
    }
}