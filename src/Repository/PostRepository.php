<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findActive()
    {
        return $this->createQueryBuilder('p')
            ->where('p.published = 1')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */

    public function findByCategory($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
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
