<?php

namespace App\Repository;

use App\Data\SearchFilter;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /***
     * Method to get all user filtered by city
     * 
     */
    /*
    public function findUserByCity($cityName)
    {
        $qb = $this->createQueryBuilder('user');

        $qb->where('user.city LIKE :city');

        $qb->setParameter(':city', "%$cityName%");

        $query = $qb->getQuery();

        return $query->getResult();
    }
*/

    /***
     * Method to get filtered user
     * 
     */
    public function findSearch(SearchFilter $search)
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('u', 's')
            ->join('u.services', 's');

        if (!empty($search->city)){
            $query = $query 
                ->andWhere('u.city like :city')
                ->setParameter('city', "%{$search->city}%");
        }

        if (!empty($search->zipCode)){
            $query = $query 
                ->andWhere('u.zipCode like :zipCode')
                ->setParameter('zipCode', "%{$search->zipCode}%");
        }

        if (!empty($search->service)){
            $query = $query 
                ->andWhere('s.id IN (:service)')
                ->setParameter('service', $search->service);
        }

        return $query->getQuery()->getResult();
    }



    /**
     * Méthode to get all angel and their services array
     *
     * @param [type] $value
     * @return User[] Returns an array of User object
     */
    public function findAngelAndServices($status)
    {
        
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :val')
            ->setParameter('val', $status)
            ->orderBy('a.id', 'ASC')
            ->leftJoin('a.services', 'services')
            ->getQuery()
            ->getResult();
    }
}
