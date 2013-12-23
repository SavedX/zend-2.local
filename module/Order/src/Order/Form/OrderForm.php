<?php
namespace Order\Form;

use Zend\Form\Form;
//use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Validator;

class OrderForm extends Form
{
    public function __construct($car_id, $name = null)
    {
        parent::__construct('order');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'car_id',
            'attributes' => array(
                'type'  => 'text',
                'value' =>  $car_id
            ),
        ));

        $this->add(array(
            'name' => 'first_name',
            'required' => true,
            'attributes' => array(
                'class' => 'span4',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Фамилия',
            ),
        ));

        $this->add(array(
            'name' => 'second_name',
            'required' => true,
            'attributes' => array(
                'class' => 'span4',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Имя',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'attributes' => array(
                'type'  => 'text',
                'class' => 'span4',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'class' => 'span4',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Город',
            ),
        ));

        $this->add(array(
            'name' => 'phone',
//            'required' => true,
            'attributes' => array(
                'class' => 'span4',
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Телефон',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
}
