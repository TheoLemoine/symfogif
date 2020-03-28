<?php


namespace App\Repository;


use App\Entity\Gif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GifRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gif::class);
    }

    public function searchByTags(string $searchTerms)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('gif')
            ->from('App:Gif', 'gif')
            ->where($queryBuilder->expr()->like('gif.tags', ':search' ))
            ->orderBy('gif.createdAt', 'DESC')
            ->setParameter('search', '%'.$searchTerms.'%');

        return $queryBuilder->getQuery()->getResult();
    }
}