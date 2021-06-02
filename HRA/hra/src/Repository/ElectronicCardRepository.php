<?php

namespace App\Repository;

use App\Entity\ElectronicCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElectronicCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectronicCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectronicCard[]    findAll()
 * @method ElectronicCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectronicCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectronicCard::class);
    }

    // /**
    //  * @return ElectronicCard[] Returns an array of ElectronicCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElectronicCard
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
