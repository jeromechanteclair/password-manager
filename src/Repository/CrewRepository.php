<?php

namespace App\Repository;

use App\Entity\Crew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Crew|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crew|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crew[]    findAll()
 * @method Crew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Crew::class);
    }
    /**
     * Repository method for finding the newest inserted
     * entry inside the database. Will return the latest
     * entry when one is existent, otherwise will return
     * null.
      * @return Crew[] Returns an array of Crew objects
     */
    public function findLastInserted()
    {
        return $this
            ->createQueryBuilder("e")
            ->orderBy("e.id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Crew[] Returns an array of Crew objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Crew
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
