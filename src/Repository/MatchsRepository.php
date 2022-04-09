<?php

namespace App\Repository;

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
