<?php

namespace App\Repository;

use App\Entity\Arbitre;
use App\Entity\Classment;
use App\Entity\Equipe;
use App\Entity\Matchs;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Matchs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matchs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matchs[]    findAll()
 * @method Matchs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class  MatchsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matchs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Matchs $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Matchs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Matchs[] Returns an array of Matchs objects
     */

    public function getTodayMatchs()
    {

        $atStartOfDay = new DateTime();
        $atEndOfDay = new DateTime();

        $atStartOfDay->setTime(0, 0, 0, 0);
        $atEndOfDay->setTime(23, 59, 59, 59);


        return $this->createQueryBuilder('m')
            ->andWhere('m.date >= :valDeb')
            ->andWhere('m.date <= :valFin')
            ->setParameter('valDeb', $atStartOfDay)
            ->setParameter('valFin', $atEndOfDay)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getNextMatchs()
    {

        $atEndOfDay = new DateTime();

        $atEndOfDay->setTime(23, 59, 59, 59);


        return $this->createQueryBuilder('m')
            ->andWhere('m.date > :valDeb')
            ->setParameter('valDeb', $atEndOfDay)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getMatchHistory(int $saison)
    {

        $atEndOfDay = new DateTime();

        $atEndOfDay->setTime(0, 0, 0, 0);


        return $this->createQueryBuilder('m')
            ->andWhere('m.date < :valDeb')
            ->andWhere('m.saison = :saison')
            ->setParameter('valDeb', $atEndOfDay)
            ->setParameter('saison', $saison)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function trigeausort($saison)
    {
        $matchs = array();
        $equipeRepository = $this->getEntityManager()->getRepository(Equipe::class);
        $classmentRepesitory = $this->getEntityManager()->getRepository(Classment::class);
        $equipes = $equipeRepository->findAll();
        $equipe1 = array();
        $equipe2 = array();
        $numberOfRound = count($equipes) - 1;
        $numberOfMatchPerRound = count($equipes) / 2;

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct saison  FROM matchs where saison = ' . $saison;
        dump($sql);
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        if ($resultSet->rowCount() > 0) {
            return 'saison déja existe';
        }
        for ($i = 0; $i < count($equipes) / 2; $i++) {
            $equipe1[] = $equipes[$i];
            $equipe2[] = $equipes[count($equipes) - $i - 1];
        }

        for ($i = 0; $i < $numberOfRound; $i++) {
//            Instant matchDate = roundDate;

            for ($j = 0; $j < $numberOfMatchPerRound; $j++) {
                $match = new Matchs();
                $match->setEquipe1($equipe1[$j]);
                $match->setEquipe2($equipe2[$j]);
                $match->setNbBut1(-1);
                $match->setNbBut2(-1);
                $match->setSaison($saison);
                $arbiterRepository = $this->getEntityManager()->getRepository(Arbitre::class);
                $arbiter = $arbiterRepository->find(1);

                $match->setIdArbitre1($arbiter);
                $match->setIdArbitre2($arbiter);
                $match->setIdArbitre3($arbiter);
                $match->setIdArbitre4($arbiter);
                $match->setNbSpectateur(10000);
//                $match->setDate();
                $match->setStade($equipe1[$j]->getStade());
                $match->setRound($i + 1);
                $matchs[] = $match;
//                if (j % 3 == 0) {
//                    matchDate = roundDate.plusSeconds(3600 * 24 * (j / 3));
//                } else {
//                    matchDate = matchDate.plusSeconds(3600 * 2);
//
//                }
            }

            $auxEquipe1 = $equipe1[count($equipe1) - 1];
            $auxEquipe2 = $equipe2[0];

            for ($k = 0; $k < count($equipe2) - 1; $k++) {
                $equipe2[$k] = $equipe2[$k + 1];
            }

            for ($k = count($equipe1) - 1; $k > 1; $k--) {
                $equipe1[$k] = $equipe1[$k - 1];
            }

            $equipe1[1] = $auxEquipe2;
            $equipe2[count($equipe2) - 1] = $auxEquipe1;

//            roundDate = roundDate . plusSeconds(3600 * 24 * 7);

        }
        $matchsReversed = $this->reverseMatchsArray($matchs, $numberOfRound);

        $matchsAll = array_merge($matchs, $matchsReversed);

        foreach ($matchsAll as $match) {
            $this->_em->persist($match);
        }

        foreach ($equipes as $equipe) {
            $classment = new Classment();
            $classment->setIdEquipe($equipe);
            $classment->setSaison($saison);
            $classmentRepesitory->_em->persist($classment);
        }
        $this->_em->flush();
    }

    private function reverseMatchsArray(array $matchs, $nombreRound): array
    {
        $matchsReverserd = array();
        for ($i = 0; $i < count($matchs); $i++) {
//            match2.setDate(Timestamp.from(match.getDate().toInstant().plusSeconds(3600 * 24 * 7 * 20)));

            $newMatch = new Matchs();
            $newMatch->setEquipe1($matchs[$i]->getEquipe2());
            $newMatch->setEquipe2($matchs[$i]->getEquipe1());
            $newMatch->setNbBut1(-1);
            $newMatch->setNbBut2(-1);
            $newMatch->setSaison($matchs[$i]->getSaison());
            $newMatch->setIdArbitre1($matchs[$i]->getIdArbitre1());
            $newMatch->setIdArbitre2($matchs[$i]->getIdArbitre2());
            $newMatch->setIdArbitre3($matchs[$i]->getIdArbitre3());
            $newMatch->setIdArbitre4($matchs[$i]->getIdArbitre4());
            $newMatch->setNbSpectateur(10000);
//                $match->setDate();
            $newMatch->setStade($matchs[$i]->getEquipe2()->getStade());
            $newMatch->setRound($nombreRound + $matchs[$i]->getRound());
            $matchsReverserd[] = $newMatch;
        }

        return $matchsReverserd;

    }






    // /**
    //  * @return Matchs[] Returns an array of Matchs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Matchs
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
