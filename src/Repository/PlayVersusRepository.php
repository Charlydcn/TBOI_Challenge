<?php

namespace App\Repository;

use App\Entity\PlayVersus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayVersus>
 *
 * @method PlayVersus|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayVersus|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayVersus[]    findAll()
 * @method PlayVersus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayVersusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayVersus::class);
    }

    public function findBestRuns($versusId, $limit): array
    {
        return $this->createQueryBuilder('pv')
            ->select('pv.completionTime', 'u.username', 'pv.playDate', 'pv.comment')
            ->leftJoin('pv.user', 'u')
            ->where('pv.versus = :versusId')
            ->andWhere('pv.completionTime IS NOT NULL')
            ->setParameter('versusId', $versusId)
            ->orderBy('pv.completionTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return PlayVersus[] Returns an array of PlayVersus objects
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

//    public function findOneBySomeField($value): ?PlayVersus
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
