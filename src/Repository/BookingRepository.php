<?php

namespace App\Repository;
use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findRemainingPlacesBySession($sessionId) {
        return $this->createQueryBuilder('b')
                ->andWhere('b.session = :sessionId')
                ->setParameter('sessionId', $sessionId)
                ->getQuery()
                ->getResult();
    }

    public function findBookingBySessionIdAndUserId($sessionId, $userId) {
        return $this->createQueryBuilder('b')
            ->andWhere('b.session = :sessionId')
            ->andWhere('b.user = :userId')
            ->setParameter('sessionId', $sessionId)
            ->setParameter('sessionId', $userId)
            ->getQuery()
            ->getResult();
    }
    public function deleteBookingById($id) {
        return $this->createQueryBuilder('b')
                    ->delete(Booking::class, 'b')
                    ->andWhere('b.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
    }
    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
