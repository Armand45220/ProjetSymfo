<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    public function save(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }   

    //affichage offres permanentes

    public function affOffresPerm()
    {
        return $this->createQueryBuilder('o')
            ->select('o.id_offre, o.date_insert_offre, o.nom_offre, o.desc_offre, o.date_debut_val, o.date_fin_val, o.nb_places_min, o.lien_offre, (
                SELECT GROUP_CONCAT(f.cheminFichier SEPARATOR \',\')
                FROM App\Entity\FichierOffre fo
                JOIN fo.fichiers f
                WHERE fo.offres = o.id_offre
            ) AS fichiers')
            ->where('o.type_offre = 1')
            ->andWhere('o.num_aff != 0')
            ->getQuery()
            ->getResult();
    }

    // affichage offres limitées
    public function affOffresLim()
    {
        return $this->createQueryBuilder('o')
            ->select('o.id_offre, o.date_insert_offre, o.nom_offre, o.desc_offre, o.date_debut_aff, o.date_fin_aff, o.num_aff, o.lien_offre, (
                SELECT GROUP_CONCAT(f.cheminFichier SEPARATOR \',\')
                FROM App\Entity\FichierOffre fo
                JOIN fo.fichiers f
                WHERE fo.offres = o.id_offre
            ) AS fichiers')
            ->orderBy('o.num_aff', 'ASC')
            ->addOrderBy('o.id_offre', 'ASC')
            ->where('o.type_offre = 2')
            ->andWhere('o.num_aff != 0')
            ->getQuery()
            ->getResult();
    }
    
    public function affOffresLimAccueil()
    {
        $query = $this->createQueryBuilder('o')
        ->select('o.id_offre, o.date_insert_offre, o.nom_offre, o.desc_offre, o.date_debut_aff, o.date_fin_aff, o.num_aff, o.lien_offre, (
            SELECT GROUP_CONCAT(f.cheminFichier SEPARATOR \',\')
            FROM App\Entity\FichierOffre fo
            JOIN fo.fichiers f
            WHERE fo.offres = o.id_offre
        ) AS fichiers')
        ->where('o.type_offre = 2')
        ->orderBy('o.num_aff', 'ASC');
    
        // Les 3 offres avec les plus gros ID d'offre de type 2
        $query1 = clone $query;
        $results1 = $query1->orderBy('o.id_offre', 'DESC')
                        ->setMaxResults(3)
                        ->getQuery()
                        ->getResult();
    
        // Le reste des offres de type 2, en excluant les offres déjà affichées dans la première requête
        $query2 = clone $query;
        $query2->andWhere('o.id_offre NOT IN (:ids)')
                ->setParameter('ids', array_map(function($offre) {
                    return $offre['id_offre'];
                }, $results1));
        $results2 = $query2->orderBy('o.num_aff', 'ASC')
                        ->getQuery()
                        ->getResult();
    
        // On retourne les deux résultats combinés
        return array_merge($results1, $results2);
    }

    //actualisation des offres limitées 
    public function actualiserOffresLim()
    {
        $dateActuelle = new \DateTime();

        $offres = $this->findBy(['type_offre' => 2]);

        foreach ($offres as $offre) {
            if ($offre->getDateFinAff() < $dateActuelle) {
                $offre->setNumAff(0);
            }
        }

        $this->_em->flush();
    }

    //actualisation des offres limitées 
    public function actualiserOffresPerm()
    {
        $dateActuelle = new \DateTime();

        $offres = $this->findBy(['type_offre' => 1]);

        foreach ($offres as $offre) {
            if ($offre->getDateFinVal() < $dateActuelle) {
                $offre->setNumAff(0);
            }
        }

        $this->_em->flush();
    }

    public function recentOffer(int $typeOffre, ?int $numAff): array
    {
        $query = $this->createQueryBuilder('of');
        $query
                ->andWhere('of.type_offre = :type')
                ->setParameter('type', $typeOffre)
                ->orderBy('of.id','ASC')
        ;

        return $query->getQuery()->getResult();
    }

    public function findMostRecentOffer(int $numOffre): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id_offre = :val')
            ->setParameter('val', $numOffre)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


}
