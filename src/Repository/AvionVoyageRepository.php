<?php

namespace App\Repository;

use App\Entity\AvionVoyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvionVoyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvionVoyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvionVoyage[]    findAll()
 * @method AvionVoyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvionVoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvionVoyage::class);
    }

    // /**
    //  * @return AvionVoyage[] Returns an array of AvionVoyage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AvionVoyage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
