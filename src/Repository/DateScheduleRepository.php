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
    /**
     * Repository method for finding the newest inserted
     * entry inside the database. Will return the latest
     * entry when one is existent, otherwise will return
     * null.
      * @return DateSchedule[] Returns an array of Crew objects
     */
    public function findnextInserted()
    {
        $req = "SELECT AUTO_INCREMENT as last_id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'date_schedule'";
        $connection= $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($req);
        $stmt->execute();
        $row = $stmt->fetch();
        return  $typeId = $row['last_id'];
    }

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
