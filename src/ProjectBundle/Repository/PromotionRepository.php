<?php

namespace ProjectBundle\Repository;

/**
 * PromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PromotionRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllData($arr_query_data=false)
  {
    $qb = $this->createQueryBuilder('n')
                ->orderBy('n.publicDate', 'DESC')
                ->addOrderBy('n.createdAt', 'DESC');
    $q = $arr_query_data['q'];
    if($q){
      $qb->where($qb->expr()->orX(
        $qb->expr()->like('n.title', ':query'),
        $qb->expr()->like('n.shortDesc', ':query'),
        $qb->expr()->like('n.description', ':query')
      ))
      ->setParameter('query', '%'.$q.'%');
    }
    return $qb;
  }

	public function findAllActiveData($arr_query_data=false)
	{
		return $this->findAllData($arr_query_data)->andWhere('n.status = 1 ')->groupBy('n.id');
	}

	public function getActiveDataById($id)
  {
    $qb = $this->findAllActiveData();
    $qb->andWhere($qb->expr()->andX(
          $qb->expr()->like('n.id', ':id')
        ))
        ->setParameter('id',$id)
      ;
    return $qb;
  }
}