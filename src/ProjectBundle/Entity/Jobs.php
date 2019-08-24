<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\JobsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Jobs
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="smallint")
     */
    private $jobPositionOpening;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
     */
    private $position = 0;

    /**
    * @ORM\Column(type="smallint")
    */
    private $status = 1;

    /**
     * @ORM\Column(name="public_date", type="date", nullable=true)
    */
    private $publicDate;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

  	/** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;


    /**
     * @ORM\OneToMany(targetEntity="ApplyJobs", mappedBy="jobs")
     */
    private $applyJobs;



    /**
    * @ORM\ManyToOne(targetEntity="JobLocation", inversedBy="jobs")
    * @ORM\JoinColumn(name="job_location_id", referencedColumnName="id")
    */
    private $jobLocation;


    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __construct()
    {
      $this->applyJobs = new ArrayCollection();

    }

    /**
  	 *
  	 * @ORM\PrePersist
  	 * @ORM\PreUpdate
  	 */
  	public function updatedTimestamps()
  	{
      $this->setUpdatedAt(new \DateTime('now'));
      if ($this->getCreatedAt() == null) {
        $this->setCreatedAt(new \DateTime('now'));
      }
  	}

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Position
     *
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of Position
     *
     * @param mixed position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }



    /**
     * Get the value of Job Position Opening
     *
     * @return mixed
     */
    public function getJobPositionOpening()
    {
        return $this->jobPositionOpening;
    }

    /**
     * Set the value of Job Position Opening
     *
     * @param mixed jobPositionOpening
     *
     * @return self
     */
    public function setJobPositionOpening($jobPositionOpening)
    {
        $this->jobPositionOpening = $jobPositionOpening;

        return $this;
    }

    /**
     * Get the value of Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param mixed status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of Public Date
     *
     * @return mixed
     */
    public function getPublicDate()
    {
        return $this->publicDate;
    }

    /**
     * Set the value of Public Date
     *
     * @param mixed publicDate
     *
     * @return self
     */
    public function setPublicDate($publicDate)
    {
        $this->publicDate = $publicDate;

        return $this;
    }

    /**
     * Get the value of Apply Jobs
     *
     * @return mixed
     */
    public function getApplyJobs()
    {
        return $this->applyJobs;
    }

    /**
     * Set the value of Apply Jobs
     *
     * @param mixed applyJobs
     *
     * @return self
     */
    public function setApplyJobs($applyJobs)
    {
        $this->applyJobs = $applyJobs;

        return $this;
    }


    /**
     * Get the value of Job Location
     *
     * @return mixed
     */
    public function getJobLocation()
    {
        return $this->jobLocation;
    }

    /**
     * Set the value of Job Location
     *
     * @param mixed jobLocation
     *
     * @return self
     */
    public function setJobLocation($jobLocation)
    {
        $this->jobLocation = $jobLocation;

        return $this;
    }

}
