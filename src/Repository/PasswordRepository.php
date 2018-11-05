<?php

namespace App\Repository;

use App\Entity\Password;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Password|null find($id, $lockMode = null, $lockVersion = null)
 * @method Password|null findOneBy(array $criteria, array $orderBy = null)
 * @method Password[]    findAll()
 * @method Password[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Password::class);
    }

//    /**
//     * @return Password[] Returns an array of Password objects
//     */

    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :val')
            ->setParameter('val', $user)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Password
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
