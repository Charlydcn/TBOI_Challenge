<?php

namespace App\Repository;

use App\Entity\VersusPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VersusPlayer>
 *
 * @method VersusPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VersusPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VersusPlayer[]    findAll()
 * @method VersusPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VersusPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VersusPlayer::class);
    }

//    /**
//     * @return VersusPlayer[] Returns an array of VersusPlayer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VersusPlayer
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
