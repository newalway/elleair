<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Symfony\Component\Intl\Locale;

/**
 * JobsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JobsRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('j');
		//join translation
		$this->qb->join('j.translations', 'jt')
				->select('j', 'jt')
				->where("jt.locale = '$locale'")
				->orderBy('j.position', 'ASC')
				->addOrderBy('j.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

  		return $this->qb;
    }

	public function findAllDataActive($arr_query_data=false, $locale=false)
	{
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->findAllData($arr_query_data,$locale);
			$this->qb->andWhere('j.status = 1');
			$this->qb->andWhere('j.publicDate <= NOW()');

		return $this->qb;
	}

	public function findAllDataActiveById($job_id)
	{
		// $locale = ($locale) ? $locale : Locale::getDefault();
		// $arr_query_data=false;

		$this->findAllDataActive();

		if($job_id){
			$this->qb->andWhere($this->qb->expr()->andX(
				$this->qb->expr()->eq('j.id', ':job_id')
			))
			->setParameter('job_id',$job_id);
		}

		return $this->qb;
	}




	protected function setSearchData($arr_query_data)
	{
		if(!isset($arr_query_data)){
			$q = $arr_query_data['q'];
			if($q){
				//search from translation
				$this->qb->where($this->qb->expr()->orX(
					$this->qb->expr()->like('jt.title', ':query')
				))
				->setParameter('query', '%'.$q.'%');
			}
		}

	}

}