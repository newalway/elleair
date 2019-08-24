<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * AttachFile
 *
 * @ORM\Table(name="attach_file")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\AttachFileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class AttachFile
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
    * @ORM\ManyToOne(targetEntity="ApplyJobs", inversedBy="attachFile")
    * @ORM\JoinColumn(name="apply_jobs_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $applyJobs;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255 , nullable = true)
    */
    private $name;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable = true)
    */
    private $fileUploadPath;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable = true)
    */
    private $fileUploadName;

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
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of File Upload Path
     *
     * @return string
     */
    public function getFileUploadPath()
    {
        return $this->fileUploadPath;
    }

    /**
     * Set the value of File Upload Path
     *
     * @param string fileUploadPath
     *
     * @return self
     */
    public function setFileUploadPath($fileUploadPath)
    {
        $this->fileUploadPath = $fileUploadPath;

        return $this;
    }

    /**
     * Get the value of File Upload Name
     *
     * @return string
     */
    public function getFileUploadName()
    {
        return $this->fileUploadName;
    }

    /**
     * Set the value of File Upload Name
     *
     * @param string fileUploadName
     *
     * @return self
     */
    public function setFileUploadName($fileUploadName)
    {
        $this->fileUploadName = $fileUploadName;

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
