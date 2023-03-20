<?php

namespace App\Repository;


use App\Entity\Admin;
use App\Entity\Offre;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Admin>
 *
 * @method Admin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Admin[]    findAll()
 * @method Admin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
        parent::__construct($registry, Offre::class);

    }




    public function save(Admin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Admin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getOfferslAdmin()
    {
        $type = 2;
        $qb = $this->createQueryBuilder('o')
            ->select('o.id_offre, o.nom_offre, o.desc_offre, o.lien_offre, o.date_debut_aff, o.date_fin_aff, o.num_aff')
            ->where('o.type_offre = :type')
            ->setParameter('type', $type);
    
        return $qb->getQuery()->getResult();
    }

    
    public function getOfferspAdmin()
    {
        $type = 1;
        $qb = $this->createQueryBuilder('o')
            ->select('o.id_offre, o.nom_offre, o.desc_offre, o.lien_offre, o.date_debut_val, o.date_fin_val, o.nb_places_min')
            ->where('o.type_offre = :type')
            ->setParameter('type', $type);
    
        return $qb->getQuery()->getResult();
    }



//    /**
//     * @return Admin[] Returns an array of Admin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Admin
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}