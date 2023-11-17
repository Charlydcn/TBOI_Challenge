<?php

namespace App\Repository;

use App\Entity\PlayChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayChallenge>
 *
 * @method PlayChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayChallenge[]    findAll()
 * @method PlayChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayChallenge::class);
    }

    public function findBestRuns($challengeId, $limit): array
    {
        return $this->createQueryBuilder('pc')
            ->select('pc.completionTime', 'u.username', 'pc.playDate', 'pc.comment')
            ->leftJoin('pc.user', 'u')
            ->where('pc.challenge = :challengeId')
            ->andWhere('pc.completionTime IS NOT NULL')
            ->setParameter('challengeId', $challengeId)
            ->orderBy('pc.completionTime', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }



//    /**
//     * @return PlayChallenge[] Returns an array of PlayChallenge objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlayChallenge
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
