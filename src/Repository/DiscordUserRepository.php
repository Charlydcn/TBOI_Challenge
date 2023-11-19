<?php

namespace App\Repository;

use App\Entity\DiscordUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiscordUser>
 *
 * @method DiscordUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscordUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscordUser[]    findAll()
 * @method DiscordUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscordUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscordUser::class);
    }

//    /**
//     * @return DiscordUser[] Returns an array of DiscordUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DiscordUser
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
