<?php

namespace App\Repository;

use App\Entity\CandidatsAccepter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidatsAccepter>
 *
 * @method CandidatsAccepter|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatsAccepter|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatsAccepter[]    findAll()
 * @method CandidatsAccepter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatsAccepterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatsAccepter::class);
    }

    public function add(CandidatsAccepter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CandidatsAccepter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CandidatsAccepter[] Returns an array of CandidatsAccepter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CandidatsAccepter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
