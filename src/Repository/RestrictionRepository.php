<?php

namespace App\Repository;

use App\Entity\Restriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restriction>
 *
 * @method Restriction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restriction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restriction[]    findAll()
 * @method Restriction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestrictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restriction::class);
    }

//    /**
//     * @return Restriction[] Returns an array of Restriction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restriction
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
