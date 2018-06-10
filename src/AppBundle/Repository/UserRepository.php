<?php

namespace AppBundle\Repository;

/**
 * WorkLicenceTypeRepository
 *
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function getUsersWithData() 
    {
        //find users exclude admins
        $roleAdmin = 'ROLE_ADMIN';

        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.email as email, a.enabled as enabled, d.name as name, d.surname as surname, g.name as groupData')
            ->where('a.roles NOT LIKE :roleAdmin')
            ->setParameter('roleAdmin', '%'.$roleAdmin.'%')
                ->leftJoin('a.groupData', 'd')
                    ->leftJoin('d.groupName', 'g')
            ->getQuery();

        return $query->getResult();
    }

    public function findOneByEmailData($email) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id')
            ->where('a.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    
    public function findOneByEmailAndEmailData($email, $emailData)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id')
            ->where('a.email = :email')
            ->setParameter('email', $email)
            ->andWhere('a.email != :emailData')
            ->setParameter('emailData', $emailData)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
    public function findOneByUserId($userId) 
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.email as email, d.name as name, d.surname as surname, g.id as groupData')
            ->where('a.id = :userId')
            ->setParameter('userId', $userId)
                ->leftJoin('a.groupData', 'd')
                    ->leftJoin('d.groupName', 'g')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

}
