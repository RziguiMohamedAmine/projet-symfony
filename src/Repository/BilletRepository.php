<?php

namespace App\Repository;

use App\Entity\Billet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;


/**
 * @method Billet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billet[]    findAll()
 * @method Billet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Billet $entity, bool $flush = true): void
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
    public function remove(Billet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getValidBillet(int $idUser)
    {

        $atEndOfDay = new DateTime();

//        $atEndOfDay->setTime(0, 0, 59, 59);


        return $this->createQueryBuilder('b')
            ->andWhere('b.idUser = :idUser')
            ->join('b.idMatch', 'm')
            ->andWhere('m.date > :valDeb')
            ->setParameter('valDeb', $atEndOfDay)
            ->setParameter('idUser', $idUser)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getInvalidBillet(int $idUser)
    {

        $atEndOfDay = new DateTime();

        $atEndOfDay->setTime(0, 0, 0, 0);


        return $this->createQueryBuilder('b')
            ->andWhere('b.idUser = :idUser')
            ->join('b.idMatch', 'm')
            ->andWhere('m.date < :valDeb')
            ->setParameter('valDeb', $atEndOfDay)
            ->setParameter('idUser', $idUser)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function BilletDisponible($id)
    {
        $now = new DateTime();
        $dql = $this->_em->createQuery("select m, (select count(b.id) from App\Entity\Billet b where b.idMatch = m.id) from App\Entity\Matchs m where m.date> :date and m.id = $id order by m.date");
        $dql->setParameter('date', $now);
        $match = $dql->getResult();
        return $match[0][0]->getNbSpectateur() > $match[0][1];
    }



    // /**
    //  * @return Billet[] Returns an array of Billet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Billet
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
