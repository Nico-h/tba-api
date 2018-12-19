<?php

namespace App\Traits;

use App\Entity\Player;
use App\Entity\Tournament;
use App\Entity\Game;

trait ObjectFactory {

    /**
     * @param Tournament $tournament
     * @return array
     */
    private function buildTournamentArray(Tournament $tournament) {
        $tournamentArray['name'] = $tournament->getName();
        $tournamentArray['type'] = $tournament->getType();
        $tournamentArray['area'] = $tournament->getArea();

        return $tournamentArray;
    }

    /**
     * @param Game $game
     * @return array
     */
    public function buildGameArray(Game $game) {
        $gameArray['tournament'] = $game->getTournament()->getName();
        $gameArray['round'] = $game->getRound();
        $gameArray['datetime'] = $game->getDatetime();
        $gameArray['player_a'] = $game->getPlayerA()->getName();
        $gameArray['player_b'] = $game->getPlayerB()->getName();
        $gameArray['odd_a'] = floatval($game->getOddA());
        $gameArray['odd_b'] = $game->getOddB();
        $gameArray['player_won'] = $game->getPlayerWon()->getName();
        $gameArray['favorite_won'] = $game->getFavoriteWon();

        return $gameArray;
    }

    /**
     * @param Player $player
     * @param Game[] $games
     * @param int $victories
     * @param $history
     * @return array
     */
    public function buildPlayerArray(Player $player, $games, $victories, $history) {
        $playerArray['id'] = $player->getId();
        $playerArray['name'] = $player->getName();
        $playerArray['victories'] = $victories;
        $playerArray['games'] = $this->buildGameListArray($games);
        $playerArray['profile'] = $history;

        return $playerArray;
    }

    /**
     * @param Game[] $games
     * @return array
     */
    public function buildGameListArray($games) {

        $gameList = [];
        foreach ($games as $game) {
            array_push($gameList, $this->buildGameArray($game));
        }

        return $gameList;
    }
}