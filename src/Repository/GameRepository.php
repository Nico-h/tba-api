<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param int $playerId
     * @param int $limit
     * @return Game[]
     */
    public function getPlayerGames($playerId, $limit = 5): array {

        return $this->createQueryBuilder('g')
            ->where('g.player_a = :playerId')
            ->orWhere('g.player_b = :playerId')
            ->setParameter('playerId', $playerId)
            ->setMaxResults($limit)
            ->orderBy('g.datetime', 'desc')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $tournamentType
     * @param string $area
     * @param string $round
     * @param int $odd
     * @return Game[]
     */
    public function getGamesByTournamentTypeAreaRoundAndOdd($tournamentType, $area, $round, $odd) {

        $this->getOddIntervals($odd, $intervalMin, $intervalMax);

        return $this->createQueryBuilder('g')
            ->select('count(g.id)')
            ->where('g.round = :round')
            ->andWhere('t.type = :tournamentType')
            ->andWhere('t.area = :area')
            ->andWhere('g.odd_a BETWEEN :intervalMin AND :intervalMax')->orWhere('g.odd_b BETWEEN :intervalMin AND :intervalMax')
            ->innerJoin('g.tournament', 't')
            ->setParameter('round', $round)
            ->setParameter('area', $area)
            ->setParameter('tournamentType', $tournamentType)
            ->setParameter('intervalMin', $intervalMin)
            ->setParameter('intervalMax', $intervalMax)
            ->getQuery()
            ->getScalarResult()
            ;
    }

    /**
     * @param string $tournamentType
     * @param string $area
     * @param string $round
     * @param int $odd
     * @return Game[]
     */
    public function getVictoriesByTournamentTypeAreaRoundAndOdd($tournamentType, $area, $round, $odd) {

        $this->getOddIntervals($odd, $intervalMin, $intervalMax);

        return $this->createQueryBuilder('g')
            ->select('count(g.id)')
            ->where('g.round = :round')
            ->andWhere('t.type = :tournamentType')
            ->andWhere('t.area = :area')
            ->andWhere('g.favorite_won = :favorite_won')
            ->andWhere('g.odd_a BETWEEN :intervalMin AND :intervalMax')->orWhere('g.odd_b BETWEEN :intervalMin AND :intervalMax')
            ->innerJoin('g.tournament', 't')
            ->setParameter('round', $round)
            ->setParameter('area', $area)
            ->setParameter('tournamentType', $tournamentType)
            ->setParameter('intervalMin', $intervalMin)
            ->setParameter('intervalMax', $intervalMax)
            ->setParameter('favorite_won', true)
            ->getQuery()
            ->getScalarResult()
            ;

    }

    private function getOddIntervals($odd, &$intervalMin, &$intervalMax) {

        switch ($odd) {
            case 1: $intervalMin = 1.1; $intervalMax = 1.2; break;
            case 2: $intervalMin = 1.2; $intervalMax = 1.3; break;
            case 3: $intervalMin = 1.3; $intervalMax = 1.4; break;
            case 4: $intervalMin = 1.4; $intervalMax = 1.5; break;
            case 5: $intervalMin = 1.5; $intervalMax = 1.6; break;
            case 6: $intervalMin = 1.6; $intervalMax = 1.7; break;
            case 7: $intervalMin = 1.7; $intervalMax = 1.8; break;
            case 8: $intervalMin = 1.8; $intervalMax = 1.85; break;
            default: $intervalMin = 0; $intervalMax = 0; break;
        }
    }

//    /**
//     * @return Game[] Returns an array of Game objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
