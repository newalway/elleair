<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ApplyJobs
 *
 * @ORM\Table(name="apply_jobs")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ApplyJobsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ApplyJobs
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
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $firstName;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255,nullable = true)
    */
    private $lastName;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255,nullable = true)
    */
    private $firstNameEN;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255,nullable = true)
    */
    private $lastNameEN;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $email;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255,nullable = true)
    */
    private $phone;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255,nullable = true)
    */
    private $message;


    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

  	/** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;


    /**
    * @ORM\ManyToOne(targetEntity="Jobs", inversedBy="applyJobs")
    * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
    */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="applyJobs" ,cascade={"persist"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="AttachFile", mappedBy="applyJobs" ,cascade={"persist"})
     */
    private $attachFile;

    /**
     * @ORM\OneToMany(targetEntity="ComputerSkill", mappedBy="applyJobs",cascade={"persist"})
     */
    private $computerSkill;


    /**
     * @ORM\OneToMany(targetEntity="Educational", mappedBy="applyJobs",cascade={"persist"})
     */
    private $educational;

    /**
     * @ORM\OneToMany(targetEntity="LanguageSkill", mappedBy="applyJobs",cascade={"persist"})
     */
    private $languageSkill;

    /**
     * @ORM\OneToMany(targetEntity="OtherSkill", mappedBy="applyJobs",cascade={"persist"})
     */
    private $otherSkill;

    /**
     * @ORM\OneToMany(targetEntity="Training", mappedBy="applyJobs",cascade={"persist"})
     */
    private $training;

    /**
     * @ORM\OneToMany(targetEntity="WorkExperience", mappedBy="applyJobs",cascade={"persist"})
     */
    private $workExperience;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 4;


    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->attachFile = new ArrayCollection();
        $this->computerSkill = new ArrayCollection();
        $this->educational = new ArrayCollection();
        $this->languageSkill = new ArrayCollection();
        $this->otherSkill = new ArrayCollection();
        $this->training = new ArrayCollection();
        $this->workExperience = new ArrayCollection();
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
     * Get the value of Name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of Last Name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of Last Name
     *
     * @param string lastName
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param string email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of Phone
     *
     * @param string phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of Message
     *
     * @param string message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
     * Get the value of Jobs
     *
     * @return mixed
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set the value of Jobs
     *
     * @param mixed jobs
     *
     * @return self
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;

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
     * Get the value of Address
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param mixed address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of Attach File
     *
     * @return mixed
     */
    public function getAttachFile()
    {
        return $this->attachFile;
    }

    /**
     * Set the value of Attach File
     *
     * @param mixed attachFile
     *
     * @return self
     */
    public function setAttachFile($attachFile)
    {
        $this->attachFile = $attachFile;

        return $this;
    }

    /**
     * Get the value of Computer Skill
     *
     * @return mixed
     */
    public function getComputerSkill()
    {
        return $this->computerSkill;
    }

    /**
     * Set the value of Computer Skill
     *
     * @param mixed computerSkill
     *
     * @return self
     */
    public function setComputerSkill($computerSkill)
    {
        $this->computerSkill = $computerSkill;

        return $this;
    }

    /**
     * Get the value of Educational
     *
     * @return mixed
     */
    public function getEducational()
    {
        return $this->educational;
    }

    /**
     * Set the value of Educational
     *
     * @param mixed educational
     *
     * @return self
     */
    public function setEducational($educational)
    {
        $this->educational = $educational;

        return $this;
    }

    /**
     * Get the value of Language Skill
     *
     * @return mixed
     */
    public function getLanguageSkill()
    {
        return $this->languageSkill;
    }

    /**
     * Set the value of Language Skill
     *
     * @param mixed languageSkill
     *
     * @return self
     */
    public function setLanguageSkill($languageSkill)
    {
        $this->languageSkill = $languageSkill;

        return $this;
    }

    /**
     * Get the value of Other Skill
     *
     * @return mixed
     */
    public function getOtherSkill()
    {
        return $this->otherSkill;
    }

    /**
     * Set the value of Other Skill
     *
     * @param mixed otherSkill
     *
     * @return self
     */
    public function setOtherSkill($otherSkill)
    {
        $this->otherSkill = $otherSkill;

        return $this;
    }

    /**
     * Get the value of Training
     *
     * @return mixed
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * Set the value of Training
     *
     * @param mixed training
     *
     * @return self
     */
    public function setTraining($training)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get the value of Work Experience
     *
     * @return mixed
     */
    public function getWorkExperience()
    {
        return $this->workExperience;
    }

    /**
     * Set the value of Work Experience
     *
     * @param mixed workExperience
     *
     * @return self
     */
    public function setWorkExperience($workExperience)
    {
        $this->workExperience = $workExperience;

        return $this;
    }


    /**
     * Get the value of First Name
     *
     * @return string
     */
    public function getFirstNameEN()
    {
        return $this->firstNameEN;
    }

    /**
     * Set the value of First Name
     *
     * @param string firstNameEN
     *
     * @return self
     */
    public function setFirstNameEN($firstNameEN)
    {
        $this->firstNameEN = $firstNameEN;

        return $this;
    }

    /**
     * Get the value of Last Name
     *
     * @return string
     */
    public function getLastNameEN()
    {
        return $this->lastNameEN;
    }

    /**
     * Set the value of Last Name
     *
     * @param string lastNameEN
     *
     * @return self
     */
    public function setLastNameEN($lastNameEN)
    {
        $this->lastNameEN = $lastNameEN;

        return $this;
    }

}
