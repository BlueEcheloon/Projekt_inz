<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\Worker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Device>
 *
 * @method Device|null find($id, $lockMode = null, $lockVersion = null)
 * @method Device|null findOneBy(array $criteria, array $orderBy = null)
 * @method Device[]    findAll()
 * @method Device[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function save(Device $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Device $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findManufacturer(): array
    {
        $table = $this->createQueryBuilder('d')
            ->addGroupBy('d.manufacturer')
            ->select('d.manufacturer,count(d.manufacturer) as counter')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }

    public function findManufacturerForGroup($workers): array
    {
        $table = $this->createQueryBuilder('d')
            ->where('d.user IN (:val)')
            ->setParameter('val',$workers)
            ->addGroupBy('d.manufacturer')
            ->select('d.manufacturer,count(d.manufacturer) as counter')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }

    public function findType(): array
    {
        $table = $this->createQueryBuilder('d')
            ->addGroupBy('d.type')
            ->select('d.type,count(d.type) as counter')
            ->getQuery()
            ->getResult()
            ;
        return $table;
    }

    public function findTypeForGroup($workers): array
    {
        $table = $this->createQueryBuilder('d')
            ->where('d.user IN (:val)')
            ->setParameter('val',$workers)
            ->addGroupBy('d.type')
            ->select('d.type,count(d.type) as counter')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }
    public function findWindows(): array
    {
        $table = $this->createQueryBuilder('d')
            ->addGroupBy('d.os')
            ->select('d.os,count(d.os) as counter')
            ->andWhere('d.type = :val')
            ->setParameter('val','Windows')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }

    public function findWindowsForGroup($workers): array
    {
        $table = $this->createQueryBuilder('d')
            ->where('d.user IN (:us)')
            ->setParameter('us',$workers)
            ->addGroupBy('d.os')
            ->select('d.os,count(d.os) as counter')
            ->andWhere('d.type = :val')
            ->setParameter('val','Windows')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }

    public function findModelSummary(): array
    {
        $table = $this->createQueryBuilder('d')
            ->select('d.manufacturer,d.model, count(d.model) as counter')
            ->addGroupBy('d.model,d.manufacturer')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }

    public function findModelSummaryForGroup($workers): array
    {
        $table = $this->createQueryBuilder('d')
            ->where('d.user IN (:us)')
            ->setParameter('us',$workers)
            ->select('d.manufacturer,d.model, count(d.model) as counter')
            ->addGroupBy('d.model,d.manufacturer')
            ->getQuery()
            ->getResult()
        ;
        return $table;
    }
//    public function findManufacturer_2($manufacturer): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.manufacturer = :val')
//            ->setParameter('val', $manufacturer)
//            ->select('count(manufacturer)')
//            ->getQuery()
//            ->getResult()
//            ;
//    }

//    /**
//     * @return Device[] Returns an array of Device objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Device
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
