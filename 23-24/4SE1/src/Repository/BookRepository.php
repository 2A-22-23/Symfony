<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
function findBookByRef($ref){
    return $this->createQueryBuilder('b')
    ->where('b.ref LIKE ?1')
    ->setParameter('1','%'.$ref.'%')->getQuery()
    ->getResult();
}
function ShowByDateNbBooks(){
    return $this->createQueryBuilder('b')
    ->join('b.author','a')->addSelect('a')
    ->where('a.nbBooks > :nb')
    ->andWhere('b.publicationDate < :date')
    ->setParameters(['nb'=>10,'date'=>'2023-01-01'])
    ->getQuery()->getResult();
}
function findByDateDQL(){
    $em=$this->getEntityManager();
    return $em->createQuery('
    select b from App\Entity\Book b where
    b.publicationDate BETWEEN ?1 and ?2')
    ->setParameters([1=>'2014-01-01',
                    2=>'2018-01-01'])
                    ->getResult();
}
}
