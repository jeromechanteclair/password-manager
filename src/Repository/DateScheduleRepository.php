<?php

namespace App\Repository;

use App\Entity\DateSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DateSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateSchedule[]    findAll()
 * @method DateSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateScheduleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DateSchedule::class);
    }

    // /**
    //  * @return DateSchedule[] Returns an array of DateSchedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateSchedule
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
