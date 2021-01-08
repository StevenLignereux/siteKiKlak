<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return int|mixed|string
     */
    public function countAllPosts(){
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->select('COUNT(p.id) as value');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param null $words
     * @param null $category
     * @return int|mixed|string
     */
    public function search($words = null, $category = null)
    {
        $query = $this->createQueryBuilder('p');

        if ($words != null){
            $query->andWhere('MATCH_AGAINST(p.title, p.content) AGAINST (:words boolean)>0')
                ->setParameter('words', $words);
        }

        if ($category != null) {
            $query->leftJoin('p.category', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $category);
        }

        return $query->getQuery()->getResult();
    }


}
