<?php

namespace App\Repository;

use App\Entity\GmapApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GmapApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method GmapApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method GmapApi[]    findAll()
 * @method GmapApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GmapApiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GmapApi::class);
    }

    // /**
    //  * @return GmapApi[] Returns an array of GmapApi objects
    //  */
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
    public function findOneBySomeField($value): ?GmapApi
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
