<?php

namespace AppBundle\Repository;

/**
 * GroupNameRepository
 *
 */
class GroupNameRepository extends \Doctrine\ORM\EntityRepository
{

    public function findOneByName($name) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id')
            ->where('a.name = :name')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneById($id) 
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findAllData() 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name')
            ->getQuery();

        $results = $query->getResult();

        $data = [];
        $data['WSZYSCY'] = 0;
        
        foreach ($results as $result) {
            $data[$result['name']] = $result['id'];
        }

        return $data;
    }

}
