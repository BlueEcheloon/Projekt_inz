<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\Specification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Specification>
 *
 * @method Specification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specification[]    findAll()
 * @method Specification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specification::class);
    }

    public function save(Specification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Specification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByDevice(Device $device)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->where('d.device = :device')
            ->setParameter('device', $device);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
//select d.name, s.warranty_exp from device as d, specification as s
// where d.id=s.device_id Order by s.warranty_exp DESC
    public function findWarrantyByDevice(){
        $qb1 = $this->createQueryBuilder('s');
        $qb1->select('s.device,s.warranty_exp');
        $query1 = $qb1->getQuery();
        $result1 = $query1->getResult();
        $qb2 = $this->createQueryBuilder('d');
        $qb2->select('d.id');
        $query2=$qb2->getQuery();
        $result2=$query2->getResult();

        return $result;
    }
//    /**
//     * @return Specification[] Returns an array of Specification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Specification
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
