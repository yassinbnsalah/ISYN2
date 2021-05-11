<?php

namespace App\Repository;

use App\Entity\VoyageOrg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VoyageOrg|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoyageOrg|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoyageOrg[]    findAll()
 * @method VoyageOrg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageOrgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoyageOrg::class);
    }

    // /**
    //  * @return VoyageOrg[] Returns an array of VoyageOrg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoyageOrg
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
