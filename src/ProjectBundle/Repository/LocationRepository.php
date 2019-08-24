<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Symfony\Component\Intl\Locale;

/**
 * LocationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocationRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('l');
		//join translation
		$this->qb->join('l.translations', 'lt')
				->select('l', 'lt')
				->where("lt.locale = '$locale'")
				->orderBy('l.position', 'ASC')
				->addOrderBy('l.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

  		return $this->qb;
    }

	protected function setSearchData($arr_query_data)
	{
		$q = $arr_query_data['q'];
  		if($q){
			//search from translation
  			$this->qb->where($this->qb->expr()->orX(
	  	      	$this->qb->expr()->like('lt.title', ':query')
			))
  			->setParameter('query', '%'.$q.'%');
  		}
	}

	public function findDataJoinedShop($locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('l');
		$this->qb->select('l', 'lt', 's', 'st')
				->join('l.translations', 'lt')
				->join('l.showrooms', 's')
				->join('s.translations', 'st')
				->where("lt.locale = '$locale'")
				->andWhere("st.locale = '$locale'")
				->orderBy('l.position', 'ASC')
				->addOrderBy('l.createdAt', 'DESC')
				->addOrderBy('s.position', 'ASC')
                ->addOrderBy('s.createdAt', 'DESC');

		return $this->qb;
	}
}
