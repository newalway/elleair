<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;



/**
 * BankAccountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BankAccountRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllData($arr_query_data=false)
    {
        $qb = $this->createQueryBuilder('ba');
        //join translation
             $qb->select('ba')
                // ->where('ba.status = :status')
                ->orderBy('ba.sort', 'ASC')
                ->addOrderBy('ba.createdAt', 'DESC');
                // ->setParameter('status', 1);//status 1 is enabled

        $q = $arr_query_data['q'];
        if($q){
            //search from translation
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('ba.title', ':query'),
                $qb->expr()->like('ba.accountName', ':query'),
                $qb->expr()->like('ba.accountNumber', ':query')
            ))
            ->setParameter('query', '%'.$q.'%');
        }

        return $qb;
    }
    public function findAllActiveData($arr_query_data=false)
    {
        $qb = $this->findAllData($arr_query_data);
                $qb->andWhere('ba.status = :status')
                ->setParameter('status', 1);

        return $qb;
    }
}
