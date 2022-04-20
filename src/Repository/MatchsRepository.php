<?php

namespace App\Repository;

use App\Entity\Arbitre;
use App\Entity\Classment;
use App\Entity\Equipe;
use App\Entity\Matchs;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use const DateTimeInterface;

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

    public function trigeausort($saison, DateTime $date)
    {
        $matchs = array();
        $equipe1 = array();
        $equipe2 = array();
        $equipeRepository = $this->getEntityManager()->getRepository(Equipe::class);
        $classmentRepesitory = $this->getEntityManager()->getRepository(Classment::class);
        $equipes = $equipeRepository->findAll();

        $numberOfRound = count($equipes) - 1;
        $numberOfMatchPerRound = count($equipes) / 2;

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct saison  FROM matchs where saison = ' . $saison;
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
            $matchDate = $date;

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
                $dateaux = new DateTime();
                $dateaux->setTimestamp($matchDate->getTimestamp());
                $match->setDate($dateaux);
                $match->setStade($equipe1[$j]->getStade());
                $match->setRound($i + 1);
                $matchs[] = $match;
                $matchDate = $date->add(new DateInterval('P1D'));

//                if ($j % 3 == 0) {
//                    $matchDate = $date->add(new DateInterval('P' . ($j / 3) . 'D'));
//                } else {
//                    $matchDate = $matchDate->add(new DateInterval('PT2H'));
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

            $date = $date->add(new DateInterval('P7D'));

        }
        dump($matchs);
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

        return "true";
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
            $date = $matchs[$i]->getDate();
            $timeSpam = ($date->getTimestamp() + (28 * 3600 * 24));
            $date1 = new DateTime();
            $date1 = $date1->setTimestamp($timeSpam);
            $newMatch->setDate($date1);
            $newMatch->setStade($matchs[$i]->getEquipe2()->getStade());
            $newMatch->setRound($nombreRound + $matchs[$i]->getRound());
            $matchsReverserd[] = $newMatch;
        }

        return $matchsReverserd;

    }

    public function haveMatch(Equipe $equipe, DateTime $date)
    {
        $atStartOfDay = $date;
        $atEndOfDay = $date;
        $atStartOfDay->setTime(0, 0, 0, 0);
        $atEndOfDay->setTime(23, 59, 59, 59);

        $qb = $this->createQueryBuilder('m')
            ->andWhere('m.equipe1 = :idEquipe')
            ->orWhere('m.equipe2 = :idEquipe')
            ->andWhere('m.date >= :valDeb')
            ->andWhere('m.date <= :valFin')
            ->setParameter('idEquipe', $equipe->getId())
            ->setParameter('valDeb', $atStartOfDay)
            ->setParameter('valFin', $atEndOfDay);
        return $qb->getQuery()->getResult();


    }

    public function updateResultClassment(Matchs $match, $nbBut1, $nbBut2)
    {

        $qb = $this->_em->createQueryBuilder();
        $query = $qb->update('App\Entity\Matchs', "m")
            ->set('m.nbBut1', ':nbBut1')
            ->set('m.nbBut2', ':nbBut2')
            ->where('m.id = :id')
            ->setParameter('nbBut1', $nbBut1)
            ->setParameter('nbBut2', $nbBut2)
            ->setParameter('id', $match->getId())
            ->getQuery()
            ->execute();
        $qb1 = $this->_em->createQueryBuilder();
        $query = $qb1->update('App\Entity\Classment', 'c');
        if ($match->getNbBut1() == -1 && $match->getNbBut2() == -1) {
            if ($nbBut1 > $nbBut2) {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', 'c.nbPoint +3')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2")
                    ->set('c.nbWin', 'c.nbWin+ 1')
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1")
                    ->set('c.nbLose', 'c.nbLose+1')
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();
            } else if ($nbBut1 < $nbBut2) {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')->set('c.nbPoint', 'c.nbPoint +3')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1")
                    ->set('c.nbWin', 'c.nbWin+ 1')
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2")
                    ->set('c.nbLose', 'c.nbLose+1')
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->getQuery()->execute();
            } else {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')->set('c.nbPoint', 'c.nbPoint +1')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1")
                    ->set('c.nbDraw', 'c.nbDraw +1')
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')->set('c.nbPoint', 'c.nbPoint +1')
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2")
                    ->set('c.nbDraw', 'c.nbDraw +1')
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->getQuery()->execute();
            }
        } else {

            $nbPoint1 = 0;
            $nbTotaleBut1 = 0;
            $nbTotaleButRecu1 = 0;
            $nbWin1 = 0;
            $nbDraw1 = 0;
            $nbLose1 = 0;
            $nbPoint2 = 0;
            $nbTotaleBut2 = 0;
            $nbTotaleButRecu2 = 0;
            $nbWin2 = 0;
            $nbDraw2 = 0;
            $nbLose2 = 0;
            if ($match->getNbBut1() > $match->getNbBut2()) {
                $nbPoint1 = $nbPoint1 - 3;
                $nbTotaleBut1 = $nbTotaleBut1 - $match->getNbBut1();
                $nbTotaleButRecu1 = $nbTotaleButRecu1 - $match->getNbBut2();
                $nbWin1 = $nbWin1 - 1;

                $nbTotaleBut2 = $nbTotaleBut2 - $match->getNbBut2();
                $nbTotaleButRecu2 = $nbTotaleButRecu2 - $match->getNbBut1();
                $nbLose2 = $nbLose2 - 1;


            } else if ($match->getNbBut1() < $match->getNbBut2()) {
                $nbPoint2 = $nbPoint2 - 3;
                $nbTotaleBut2 = $nbTotaleBut2 - $match->getNbBut2();
                $nbTotaleButRecu2 = $nbTotaleButRecu2 - $match->getNbBut1();
                $nbWin2 = $nbWin2 - 1;

                $nbTotaleBut1 = $nbTotaleBut1 - $match->getNbBut1();
                $nbTotaleButRecu1 = $nbTotaleButRecu1 - $match->getNbBut2();
                $nbLose1 = $nbLose1 - 1;
            } else {

                $nbPoint1 = $nbPoint1 - 1;
                $nbTotaleBut1 = $nbTotaleBut1 - $match->getNbBut1();
                $nbTotaleButRecu1 = $nbTotaleButRecu1 - $match->getNbBut2();
                $nbDraw1 = $nbDraw1 - 1;

                $nbPoint2 = $nbPoint2 - 1;
                $nbTotaleBut2 = $nbTotaleBut2 - $match->getNbBut2();
                $nbTotaleButRecu2 = $nbTotaleButRecu2 - $match->getNbBut1();
                $nbDraw2 = $nbDraw2 - 1;

            }

            if ($nbBut1 > $nbBut2) {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint + $nbPoint1 + 3")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1 + $nbTotaleBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2 + $nbTotaleButRecu1")
                    ->set('c.nbWin', "c.nbWin + 1 + $nbWin1")
                    ->set('c.nbDraw', "c.nbDraw + $nbDraw1")
                    ->set('c.nbLose', "c.nbLose + $nbLose1")
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint + $nbPoint2")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2 + $nbTotaleBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1+$nbTotaleButRecu2")
                    ->set('c.nbLose', "c.nbLose + 1 + $nbLose2")
                    ->set('c.nbWin', "c.nbWin +$nbWin2")
                    ->set('c.nbDraw', "c.nbDraw + $nbDraw2")
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();
            } else if ($nbBut1 < $nbBut2) {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint +$nbPoint1")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1 + $nbTotaleBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2+$nbTotaleButRecu1")
                    ->set('c.nbLose', "c.nbLose + 1 + $nbLose1")
                    ->set('c.nbDraw', "c.nbDraw + $nbDraw1")
                    ->set('c.nbWin', "c.nbWin + $nbWin1")
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint + $nbPoint2 + 3")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2 + $nbTotaleBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1 + $nbTotaleButRecu2")
                    ->set('c.nbWin', "c.nbWin + 1 +$nbWin2")
                    ->set('c.nbDraw', "c.nbDraw + $nbDraw2")
                    ->set('c.nbLose', "c.nbLose + $nbLose2")
                    ->where('c.idEquipe = :idEquipe')
                    ->andWhere('c.saison = :saison')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->setParameter('saison', $match->getSaison())
                    ->getQuery()->execute();

            } else {
                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint +1+$nbPoint1")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut2 + $nbTotaleBut1")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut1 + $nbTotaleButRecu1")
                    ->set('c.nbDraw', "c.nbDraw +1+$nbDraw1")
                    ->set('c.nbLose', "c.nbLose + $nbLose1")
                    ->set('c.nbWin', "c.nbWin + $nbWin1")
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe1()->getId())
                    ->getQuery()->execute();

                $this->_em->createQueryBuilder()
                    ->update('App\Entity\Classment', 'c')
                    ->set('c.nbPoint', "c.nbPoint +1+$nbPoint2")
                    ->set('c.nbTotaleBut', "c.nbTotaleBut + $nbBut1 + $nbTotaleBut2")
                    ->set('c.nbTotaleButRecu', "c.nbTotaleButRecu + $nbBut2 + $nbTotaleButRecu2")
                    ->set('c.nbDraw', "c.nbDraw +1+$nbDraw2")
                    ->set('c.nbLose', "c.nbLose + $nbLose2")
                    ->set('c.nbWin', "c.nbWin + $nbWin2")
                    ->where('c.idEquipe = :idEquipe')
                    ->setParameter('idEquipe', $match->getEquipe2()->getId())
                    ->getQuery()->execute();
            }


        }
        return $query;
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
