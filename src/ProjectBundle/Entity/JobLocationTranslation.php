<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * JobLocationTranslation
 *
 * @ORM\Table(name="job_location_translation")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\JobLocationTranslationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class JobLocationTranslation
{
    use ORMBehaviors\Translatable\Translation;


    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", length=16777215, nullable=true)
     */
    private $address;



    /**
     * Get the value of Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param string address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

}
