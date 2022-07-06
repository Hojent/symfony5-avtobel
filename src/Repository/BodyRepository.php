<?php

namespace App\Repository;

use App\Entity\Body;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Body|null find($id, $lockMode = null, $lockVersion = null)
 * @method Body|null findOneBy(array $criteria, array $orderBy = null)
 * @method Body[]    findAll()
 * @method Body[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BodyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */

    public function findByCategory($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.bodycat_id = :val')
            ->andWhere('p.published = :active')
            ->setParameter('val', $value)
            ->setParameter('active', 1)
            ->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
