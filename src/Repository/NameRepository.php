<?php

namespace App\Repository;

use App\Entity\Name;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;;

/**
 * @method Name|null find($id, $lockMode = null, $lockVersion = null)
 * @method Name|null findOneBy(array $criteria, array $orderBy = null)
 * @method Name[]    findAll()
 * @method Name[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NameRepository extends ServiceEntityRepository
{
    /**
     * NameRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Name::class);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function findByTextContains($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.text LIKE :val')
            ->setParameter('val', "%".$value."%")
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Name[] Returns an array of Name objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Name
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
