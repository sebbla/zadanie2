<?php

namespace Sebbla\PostBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 */
class PostRepository extends EntityRepository
{

    /**
     * Returning query for selecting all posts.
     * .
     * @return \Doctrine\ORM\Query
     */
    public function findAllQuery()
    {
        $em = $this->getEntityManager();
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
                ->from('SebblaPostBundle:Post', 'p')
                ->orderBy('p.id', 'DESC');

        return $qb->getQuery();
    }

    /**
     * Returning posts by a given options.
     * 
     * @param array $options
     * @return array
     */
    public function getPosts(array $options)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
                ->from('SebblaPostBundle:Post', 'p');
        if ($options['name']) {
            $qb->andWhere('p.name LIKE :name');
            $qb->setParameter('name', '%' . $options['name'] . '%');
        }
        if ($options['type']) {
            $qb->andWhere('p.type=:type');
            $qb->setParameter('type', $options['type']);
        }

        return $qb->getQuery()->getResult();
    }

}
