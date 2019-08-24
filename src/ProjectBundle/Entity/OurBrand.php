<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * OurBrand
 *
 * @ORM\Table(name="our_brand")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\OurBrandRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OurBrand
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
     * @var array
     *  @ORM\Column(type="array", nullable=TRUE)
     */
    protected $category;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $imageBanner;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $imageLogo;

    // /**
    //  * @ORM\Column(type="string", length=255, nullable = true)
    //  */
    // private $imageLabel;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 1;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

    /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

    // /**
    //  * @ORM\OneToMany(targetEntity="News", mappedBy="ourBrand")
    //  */
    // private $news;

    /**
     * @ORM\OneToMany(targetEntity="OurBrandVideos", mappedBy="ourBrand")
     */
    private $ourBrandVideos;


    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __construct()
    {
        $this->categoty = new ArrayCollection();
        $this->news = new ArrayCollection();
        $this->ourBrandVideos = new ArrayCollection();
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
     * Get the value of Categoty
     *
     * @return array
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of Categoty
     *
     * @param array categoty
     *
     * @return self
     */
    public function setCategory(array $category)
    {
        $this->category = $category;

        return $this;
    }


    /**
     * Get the value of Image
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of Image
     *
     * @param mixed image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of Image Banner
     *
     * @return mixed
     */
    public function getImageBanner()
    {
        return $this->imageBanner;
    }

    /**
     * Set the value of Image Banner
     *
     * @param mixed imageBanner
     *
     * @return self
     */
    public function setImageBanner($imageBanner)
    {
        $this->imageBanner = $imageBanner;

        return $this;
    }
    public function removeImageBanner()
    {
        $this->setImageBanner(null);
    }

    /**
     * Get the value of Image Logo
     *
     * @return mixed
     */
    public function getImageLogo()
    {
        return $this->imageLogo;
    }
    public function removeImageLogo()
    {
        $this->setImageLogo(null);
    }

    /**
     * Set the value of Image Logo
     *
     * @param mixed imageLogo
     *
     * @return self
     */
    public function setImageLogo($imageLogo)
    {
        $this->imageLogo = $imageLogo;

        return $this;
    }

    /**
     * Get the value of Image Label
     *
     * @return mixed
     */
    public function getImageLabel()
    {
        return $this->imageLabel;
    }

    // /**
    //  * Set the value of Image Label
    //  *
    //  * @param mixed imageLabel
    //  *
    //  * @return self
    //  */
    // public function setImageLabel($imageLabel)
    // {
    //     $this->imageLabel = $imageLabel;
    //
    //     return $this;
    // }
    //
    // public function removeImageLabel()
    // {
    //     $this->setImageLabel(null);
    // }


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


    // /**
    //  * Get the value of News
    //  *
    //  * @return mixed
    //  */
    // public function getNews()
    // {
    //     return $this->news;
    // }
    //
    // /**
    //  * Set the value of News
    //  *
    //  * @param mixed news
    //  *
    //  * @return self
    //  */
    // public function setNews($news)
    // {
    //     $this->news = $news;
    //
    //     return $this;
    // }


    /**
     * Get the value of Our Brand Videos
     *
     * @return mixed
     */
    public function getOurBrandVideos()
    {
        return $this->ourBrandVideos;
    }

    /**
     * Set the value of Our Brand Videos
     *
     * @param mixed ourBrandVideos
     *
     * @return self
     */
    public function setOurBrandVideos($ourBrandVideos)
    {
        $this->ourBrandVideos = $ourBrandVideos;

        return $this;
    }

}
