<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\AddressRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Address
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
    * @ORM\ManyToOne(targetEntity="ApplyJobs", inversedBy="address")
    * @ORM\JoinColumn(name="apply_jobs_id", referencedColumnName="id",onDelete="CASCADE")
    */
    private $applyJobs;

    /**
    * @var string
    *
    * @ORM\Column(name="house_number",type="string", length=255)
    */
    private $houseNumber;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable = true)
    */
    private $road;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable = true)
    */
    private $lane;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $subDistrict;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $district;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $province;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $postCode;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $addressType;

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
     * Get the value of House Number
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set the value of House Number
     *
     * @param string houseNumber
     *
     * @return self
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get the value of Road
     *
     * @return string
     */
    public function getRoad()
    {
        return $this->road;
    }

    /**
     * Set the value of Road
     *
     * @param string road
     *
     * @return self
     */
    public function setRoad($road)
    {
        $this->road = $road;

        return $this;
    }

    /**
     * Get the value of Sub District
     *
     * @return string
     */
    public function getSubDistrict()
    {
        return $this->subDistrict;
    }

    /**
     * Set the value of Sub District
     *
     * @param string subDistrict
     *
     * @return self
     */
    public function setSubDistrict($subDistrict)
    {
        $this->subDistrict = $subDistrict;

        return $this;
    }

    /**
     * Get the value of District
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of District
     *
     * @param string district
     *
     * @return self
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get the value of Province
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set the value of Province
     *
     * @param string province
     *
     * @return self
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get the value of Post Code
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set the value of Post Code
     *
     * @param string postCode
     *
     * @return self
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get the value of Address Type
     *
     * @return string
     */
    public function getAddressType()
    {
        return $this->addressType;
    }

    /**
     * Set the value of Address Type
     *
     * @param string addressType
     *
     * @return self
     */
    public function setAddressType($addressType)
    {
        $this->addressType = $addressType;

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
     * Get the value of Lane
     *
     * @return string
     */
    public function getLane()
    {
        return $this->lane;
    }

    /**
     * Set the value of Lane
     *
     * @param string lane
     *
     * @return self
     */
    public function setLane($lane)
    {
        $this->lane = $lane;

        return $this;
    }

}
