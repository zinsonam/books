<?php

namespace App\Repository;

use App\Entity\NewPassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewPassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewPassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewPassword[]    findAll()
 * @method NewPassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewPasswordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewPassword::class);
    }

    // /**
    //  * @return NewPassword[] Returns an array of NewPassword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewPassword
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
