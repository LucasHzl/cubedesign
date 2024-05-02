<?php

namespace App\Repository;

use App\Entity\CustomersIdea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomersIdea>
 *
 * @method CustomersIdea|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomersIdea|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomersIdea[]    findAll()
 * @method CustomersIdea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersIdeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomersIdea::class);
    }

    //    /**
    //     * @return CustomersIdea[] Returns an array of CustomersIdea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CustomersIdea
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
