<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="jobs_translation" , indexes={@ORM\Index(name="search_idx", columns={"title"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class JobsTranslation
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
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="text", length=16777215, nullable=true)
     */
    private $qualification;

    /**
     * @var string
     *
     * @ORM\Column(name="benefit_welfares", type="text", length=16777215, nullable=true)
     */
    private $benefitWelfares;



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
     * Get the value of Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param string description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set the value of Qualification
     *
     * @param string qualification
     *
     * @return self
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }


    /**
     * Get the value of Benefit Welfares
     *
     * @return string
     */
    public function getBenefitWelfares()
    {
        return $this->benefitWelfares;
    }

    /**
     * Set the value of Benefit Welfares
     *
     * @param string benefitWelfares
     *
     * @return self
     */
    public function setBenefitWelfares($benefitWelfares)
    {
        $this->benefitWelfares = $benefitWelfares;

        return $this;
    }

}
