<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Like $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function numberoflikes($ids)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery('SELECT count(a) from App\Entity\Like a WHERE (a.typeLike LIKE :type) ')->setParameter('type', 'like');
        return $query->getSingleScalarResult();
    }
    public function numberofdislikes($ids)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery('SELECT count(a) from App\Entity\Like a WHERE (a.typeLike LIKE :type) ')->setParameter('type', 'dislike');
        return $query->getSingleScalarResult();
    }

    public function existantLike($idser)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.blog = :val')
            ->setParameter('val', $idser)
            ->getQuery()
            ->getResult();

    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Like $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Like[] Returns an array of Like objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Like
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
