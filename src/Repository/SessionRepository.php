<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findByDate(\Datetime $date, $movie)
    {
        $to = new \DateTime($date->format("Y-m-d H:i:s"));
        return $this->createQueryBuilder("s")
            ->where("s.date > :to ")
            ->andWhere("s.movie = :movie")
            ->setParameter(':to', $to)
            ->setParameter('movie', $movie)
            ->getQuery()
            ->getResult();
    }

    public function findRoomBySession($sessionId)
    {
        return $this->createQueryBuilder("s")
            ->where("s.id = :sessionId")
            ->setParameter(':sessionId', $sessionId)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
