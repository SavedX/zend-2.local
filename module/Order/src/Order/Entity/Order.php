<?php

namespace Order\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;
/**
 * Order
 *
 * @ORM\Table(name="Orders")
 * @ORM\Entity(repositoryClass="Order\Entity\Order")
 * @Annotation\Name("Order")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Order
{
    protected $em;
    /**
     * @ORM\id
     * @ORM\Column(type="integer", name="id", length=10)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=100,  nullable=false)
     */
    private $first_name;

    /**
     *  @ORM\Column(name="second_name", type="string", length=100,  nullable=false)
     */
    private $second_name;

    /**
     *  @ORM\Column(name="email", type="string", length=60)
     */
    private $email;

    /**
     *  @ORM\Column(name="city", type="string", length=50)
     */
    private $city;
    /**
     *  @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;
    /**
     *  @ORM\Column(name="car_id", type="integer", length=10)
     */
    private $car_id;
    /**
     *  @ORM\Column(name="is_read", type="integer", length=1)
     *  * @Annotation\Options({
     *  * "value_options":{ "0":"new", "1":"is read"}})
     */
    private $is_read;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Annotation\Options({"label":"Registration Date:", "format":"Y-m-d\TH:iP"})
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
     * Set first_name
     *
     * @param string $first_name
     * @return Order
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set second_name
     *
     * @param string $second_name
     * @return Order
     */
    public function setSecondName($second_name)
    {
        $this->second_name = $second_name;

        return $this;
    }

    /**
     * Get second_name
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->second_name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set city
     *
     * @param integer $city
     * @return Order
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return Order
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->city;
    }

    /**
     * Set is_read
     *
     * @param integer $is_read
     * @return Order
     */
    public function setIsRead($is_read)
    {
        $this->is_read = $is_read;

        return $this;
    }

    /**
     * Get is_read
     *
     * @return string
     */
    public function getIsRead()
    {
        return $this->is_read;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Order
     */
    public function setOrderId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set car_id
     *
     * @param integer $car_id
     * @return Order
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;

        return $this;
    }

//    /**
//     * Get is_read
//     *
//     * @return integer
//     */
//    public function getIsRead()
//    {
//        return $this->$is_read;
//    }

    /**
     * Get car_id
     *
     * @return integer
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->id;
    }
}