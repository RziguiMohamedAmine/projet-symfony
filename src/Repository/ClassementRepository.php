<?php

namespace App\Repository;

use App\Entity\Classment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classment[]    findAll()
 * @method Classment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Classment $entity, bool $flush = true): void
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
    public function remove(Classment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Classment[] Returns an array of Classment objects
     */

    public function getLastSaisonClasment()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM classment c join equipe e on e.id = c.id_equipe where saison = (SELECT max(saison) FROM classment)';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }

    public function getSaisons()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT distinct saison  FROM classment c order by saison DESC';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }


    // /**
    //  * @return Classment[] Returns an array of Classment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Classment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
