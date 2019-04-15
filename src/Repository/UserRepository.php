<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function search(array $filters = [])
    {
        // constructeur de requête SQL
        // le 'u' est l'alias de la table article dans la requête
        $qb = $this->createQueryBuilder('u');

        // tri par date de publication décroissante
        $qb->orderBy('u.lastname', 'ASC');

        if (!empty($filters['lastname'])) {
            $qb
                ->andWhere('u.lastname LIKE :lastname')
                ->setParameter('lastname', '%' . $filters['lastname'] . '%')
            ;
        }

        if (!empty($filters['firstname'])) {
            $qb
                ->andWhere('u.firstname LIKE :firstname')
                ->setParameter('firstname', '%' . $filters['firstname'] . '%')
            ;
        }


        if (!empty($filters['city'])) {
            $qb
                ->andWhere('u.city LIKE :city')
                ->setParameter('city', '%' . $filters['city'] . '%')
            ;
        }

        if (!empty($filters['postalCode'])) {
            $qb
                ->andWhere('u.postalCode LIKE :postalCode')
                ->setParameter('postalCode', '%' . $filters['postalCode'] . '%')
            ;
        }

        if (!empty($filters['emploi'])) {
            $qb
                ->andWhere('u.emploi LIKE :emploi')
                ->setParameter('emploi', '%' . $filters['emploi'] . '%')
            ;
        }


        // la requête générée
        $query = $qb->getQuery();

        // on retourne le résultat de la requête
        return $query->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function globalSearch($search)
    {
        $qb = $this->createQueryBuilder('u');

        // tri par date de publication décroissante
        $qb->orderBy('u.lastname', 'ASC');

        $qb
            ->orWhere('u.lastname LIKE :search')
            ->orWhere('u.firstname LIKE :search')
            ->orWhere('u.city LIKE :search')
            ->orWhere('u.postalCode LIKE :search')
            ->orWhere('u.emploi LIKE :search')
            ->setParameter('search', '%' . $search . '%')
        ;

        $query = $qb->getQuery();

        // on retourne le résultat de la requête
        return $query->getResult();
    }
}
