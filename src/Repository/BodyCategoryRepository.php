<?php

namespace App\Repository;

use App\Entity\BodyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BodyCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BodyCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BodyCategory[]    findAll()
 * @method BodyCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BodyCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findActive()
    {
        return $this->createQueryBuilder('c')
            ->where('c.published = 1')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */

    public function findChildrenByParent($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.published = 1')
            ->andWhere('c.parent = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Category
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
