<?php

namespace Car\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation;

/**
 * Cars
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="Car\Entity\Car")
 * @Annotation\Name("car")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Car
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer", name="id", length=10)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="brand", type="string", length=100,  nullable=false)
     */
    private $brand;

    /**
     *  @ORM\Column(name="name_model", type="string", length=100,  nullable=false)
     */
    private $name_model;

    /**
     *  @ORM\Column(name="detail", type="string", length=1024,  nullable=false)
     */
    private $detail;

    /**
     *  @ORM\Column(name="photo", type="string", length=100)
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
//     * @Annotation\Attributes({"type":"datetime","min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"})
     * @Annotation\Options({"label":"Created Date:", "format":"Y-m-d\TH:iP"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set Brand
     *
     * @param string $brand
     * @return Car
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set name_model
     *
     * @param string $name_model
     * @return Car
     */
    public function setNameModel($name_model)
    {
        $this->name_model = $name_model;

        return $this;
    }

    /**
     * Get name_model
     *
     * @return string
     */
    public function getNameModel()
    {
        return $this->name_model;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return Car
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set photo
     *
     * @param integer $photo
     * @return Car
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getCarId()
    {
        return $this->id;
    }
}