<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * WorkExperience
 *
 * @ORM\Table(name="work_experience")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\WorkExperienceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class WorkExperience
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="ApplyJobs", inversedBy="workExperience")
    * @ORM\JoinColumn(name="apply_jobs_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $applyJobs;

    /**
    *
    * @ORM\Column(type="text", length=65535, nullable = true)
    */
    private $durationFromTo;

    /**
    *
    * @ORM\Column(type="text", length=65535, nullable = true)
    */
    private $workplace;

    /**
    *
    * @ORM\Column(type="text", length=65535, nullable = true)
    */
    private $position;


    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

     /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

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
     * Get the value of Duration From To
     *
     * @return mixed
     */
    public function getDurationFromTo()
    {
        return $this->durationFromTo;
    }

    /**
     * Set the value of Duration From To
     *
     * @param mixed durationFromTo
     *
     * @return self
     */
    public function setDurationFromTo($durationFromTo)
    {
        $this->durationFromTo = $durationFromTo;

        return $this;
    }

    /**
     * Get the value of Workplace
     *
     * @return mixed
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * Set the value of Workplace
     *
     * @param mixed workplace
     *
     * @return self
     */
    public function setWorkplace($workplace)
    {
        $this->workplace = $workplace;

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

}
