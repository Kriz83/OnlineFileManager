<?php

namespace AppBundle\Repository;

/**
 * CatalogueRepository
 *
 */
class CatalogueRepository extends \Doctrine\ORM\EntityRepository
{    
    public function findOneByIdData($id) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent, a.groupName as groupId')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByParentId($parent) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.id = :parent')
            ->setParameter('parent', $parent)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByIdDataObject($id) 
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByName($name, $parent) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.name = :name')
            ->setParameter('name', $name)
            ->andWhere('a.parent = :parent')
            ->setParameter('parent', $parent)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findByParent($parent) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.parent = :parent')
            ->setParameter('parent', $parent)
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function findByParentAndPrivliges($parent, $privliges) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.groupName as groupName')
            ->where('a.parent = :parent')
            ->setParameter('parent', $parent)            
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        $catalogues = $query->getResult();

        $catalogueList = [];

        foreach ($catalogues as $catalogue) {
            $cataloguePrivliges = $catalogue['groupName'];
            foreach ($cataloguePrivliges as $cataloguePrivlige) {
                if ($cataloguePrivlige == $privliges) {
                    $catalogueList[$catalogue['id']] = $catalogue['id'];
                }
            }
        }

        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.id IN (:catalogueList)')
            ->setParameter('catalogueList', $catalogueList)            
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function findByParentAndNullPriv($parent) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.parent = :parent')
            ->setParameter('parent', $parent)
            ->andWhere('a.groupName = 0')
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function findByParentsAndPrivliges($parentsData, $privliges) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.parent IN (:parentsData)')
            ->setParameter('parentsData', $parentsData)
            ->andWhere('a.groupName LIKE :privliges')
            ->setParameter('privliges', $privliges)
            ->getQuery();

        return $query->getResult();
    }

    public function findByParentsAndNullPriv($parentsData) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.parent IN (:parentsData)')
            ->setParameter('parentsData', $parentsData)
                ->andWhere('a.groupName IS null')
            ->getQuery();

        return $query->getResult();
    }

    public function findByParents($parentsData) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name, a.parent as parent')
            ->where('a.parent IN (:parentsData)')
            ->setParameter('parentsData', $parentsData)
            ->getQuery();

        return $query->getResult();
    }

    public function getCatalogueList() 
    {
        $catalogueList = [];
        
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name')
            ->getQuery();

        $catalogues = $query->getResult();

        foreach ($catalogues as $catalogue) {
            $id = $catalogue['id'];
            $name = $catalogue['name'];
            $catalogueList[$id] = $name;
        }

        return $catalogueList;
    }

    public function findByPrivliges($privliges) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.groupName as groupName')        
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        $catalogues = $query->getResult();

        $catalogueList = [];

        foreach ($catalogues as $catalogue) {
            $cataloguePrivliges = $catalogue['groupName'];
            foreach ($cataloguePrivliges as $cataloguePrivlige) {
                if ($cataloguePrivlige == $privliges || $cataloguePrivlige == 0) {
                    $catalogueList[$catalogue['id']] = $catalogue['id'];
                }
            }
        }


        return $catalogueList;
    }

}
