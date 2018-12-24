<?php

namespace App\Repository;

use App\Entity\CrewRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CrewRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method CrewRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method CrewRole[]    findAll()
 * @method CrewRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrewRoleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CrewRole::class);
    }

     /**
     * @return CrewRole[] Returns an array of CrewRole objects
      */

    public function findduplicate($crew,$user)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.crew = :crew')
            ->andWhere('c.User = :user')
            ->setParameter('crew', $crew)
            ->setParameter('user', $user)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?CrewRole
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
