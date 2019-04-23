<?php

namespace App\Repository;

use App\Entity\Messages;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    // /**
    //  * @return Messages[] Returns an array of Messages objects
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
    public function findOneBySomeField($value): ?Messages
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getLastMessages(User $user1, User $user2, $minId)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->orWhere('m.user_envoi = :user1 AND m.user_recoit = :user2')
            ->orWhere('m.user_envoi = :user2 AND m.user_recoit = :user1')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->orderBy('m.id', 'desc')
        ;

        if (!is_null($minId)) {
            $qb
                ->andWhere('m.id > :minId')
                ->setParameter('minId', $minId)
            ;
        } else {
            $qb->setMaxResults(5);
        }


        $query = $qb->getQuery();

        return $query->getResult();

    }

    public function getAllMessages(User $user)
    {
//        $qb = $this->createQueryBuilder('m');
//
//        $qb
//            ->select('')
//            ->where('m.user_recoit = :user')
//            ->setParameter('user', $user)
//            ->orderBy('m.id', 'desc')
//            ->groupBy('m.user_envoi')
//        ;
//
//        return $qb->getQuery()->getResult();
        $userId = $user->getId();
        $sql = <<<SQL
SELECT m.* FROM messages m
where m.user_recoit_id = $userId
and m.date_publication = (
  select max(date_publication)
  from messages
  where user_recoit_id = $userId
  and user_envoi_id = m.user_envoi_id
)
group by m.user_envoi_id
SQL;
/*
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Messages::class, 'm');
        $rsm->addFieldResult('m', 'content', 'content');


*/
        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata(Messages::class, 'm');

        $query = $this->_em->createNativeQuery($sql, $rsm);

        $messages = $query->getResult();

        return $messages;
    }
}

