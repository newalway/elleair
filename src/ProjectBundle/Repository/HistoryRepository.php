<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Intl\Locale;

/**
 * HistoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HistoryRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('h');
		//join translation
		$this->qb->join('h.translations', 'ht')
				->select('h', 'ht')
				->where("ht.locale = '$locale'")
				->orderBy('h.position', 'ASC')
				->addOrderBy('h.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

  		return $this->qb;
    }

	protected function setSearchData($data)
	{
  		if(isset($data['q'])){
			//search from translation
  			$this->qb->where($this->qb->expr()->orX(
	  	      	$this->qb->expr()->like('ht.title', ':query'),
				$this->qb->expr()->like('ht.description', ':query')
			))
  			->setParameter('query', '%'.$data['q'].'%');
  		}
	}
}
