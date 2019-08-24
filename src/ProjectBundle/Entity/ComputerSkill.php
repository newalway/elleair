<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * ComputerSkill
 *
 * @ORM\Table(name="computer_skill")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ComputerSkillRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ComputerSkill
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
    * @ORM\ManyToOne(targetEntity="ApplyJobs", inversedBy="computerSkill")
    * @ORM\JoinColumn(name="apply_jobs_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $applyJobs;


    /**
    *
    * @ORM\Column(type="text", length=65535, nullable = true)
    */
    private $skillText;

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
     * Get the value of Skill Text
     *
     * @return mixed
     */
    public function getSkillText()
    {
        return $this->skillText;
    }

    /**
     * Set the value of Skill Text
     *
     * @param mixed skillText
     *
     * @return self
     */
    public function setSkillText($skillText)
    {
        $this->skillText = $skillText;

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
