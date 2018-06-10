<?php

namespace AppBundle\Repository;

/**
 * DocumentRepository
 *
 */
class DocumentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneByCatalogsNull($fileName, $directory) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere(' a.catalogs IS null')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneByCatalogs($fileName, $directory) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere('a.catalogs = :directory')
            ->setParameter('directory', $directory)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getFilesByCatalogue($directory) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id, 
                a.fileName as fileName, 
                a.description as description, 
                c.id as catalogueId, 
                a.fileExtension as extension 
            ')
                ->leftJoin('a.catalogs', 'c')
                ->where('c.id = :directory')
                ->setParameter('directory', $directory)
                ->orderBy('a.fileName', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function getFilesByNullCatalogue() 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id, 
                a.fileName as fileName, 
                a.description as description, 
                c.id as catalogueId, 
                a.fileExtension as extension 
            ')
            ->where('a.catalogs IS null')
                ->leftJoin('a.catalogs', 'c')
            ->orderBy('a.fileName', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function findByFileNameAndCatalogueList($fileName, $catalogueList) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id,
                a.description as description,  
                c.id as catalogueId, 
                c.name as catalogue, 
                a.fileName as fileName, 
                a.fileExtension as extension 
            ')
            ->where('a.fileName LIKE :fileName')
            ->setParameter('fileName', '%'.addcslashes($fileName, '%_').'%')
                ->leftJoin('a.catalogs', 'c')
                ->andWhere('c.id IN (:catalogueList)')
                ->setParameter('catalogueList', $catalogueList)
            ->getQuery();

        return $query->getResult();
    }

    public function findByFileName($fileName) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id,
                a.description as description,  
                c.id as catalogueId, 
                c.name as catalogue, 
                a.fileName as fileName, 
                a.fileExtension as extension 
            ')
            ->where('a.fileName LIKE :fileName')
            ->setParameter('fileName', '%'.addcslashes($fileName, '%_').'%')
                ->leftJoin('a.catalogs', 'c')
            ->getQuery();

        return $query->getResult();
    }
    
    public function getFileByCatalogueAndFilename($fileName, $fileExtension, $catalogueId) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id
            ')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere('a.fileExtension = :fileExtension')
            ->setParameter('fileExtension', $fileExtension)
                ->leftJoin('a.catalogs', 'c')
                    ->andWhere('c.id = :catalogueId')
                    ->setParameter('catalogueId', $catalogueId)
            ->getQuery();

        return $query->getResult();
    }
        
    public function getFileToRemove($fileName, $fileExtension, $catalogueId) 
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere('a.fileExtension = :fileExtension')
            ->setParameter('fileExtension', $fileExtension)
                ->leftJoin('a.catalogs', 'c')
                    ->andWhere('c.id = :catalogueId')
                    ->setParameter('catalogueId', $catalogueId)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getFileToRemoveFromMain($fileName, $fileExtension) 
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere('a.fileExtension = :fileExtension')
            ->setParameter('fileExtension', $fileExtension)             
            ->andWhere('a.catalogs IS null')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    
    public function getFileByNullCatalogueAndFilename($fileName, $fileExtension) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('
                a.id as id
            ')
            ->where('a.fileName = :fileName')
            ->setParameter('fileName', $fileName)
            ->andWhere('a.fileExtension = :fileExtension')
            ->setParameter('fileExtension', $fileExtension)
            ->andWhere('a.catalogs IS null')
            ->getQuery();

        return $query->getResult();
    }

}
