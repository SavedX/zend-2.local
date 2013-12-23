<?php
namespace Order\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class OrderFilter extends InputFilter
{
	public function __construct($sm)
	{
        $this->add(array(
            'name'     => 'first_name',
            'required' => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'second_name',
            'required' => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

		$this->add(array(
			'name'     => 'email',
			'required' => true,
			'validators' => array(
                    array(
                        'name' => 'EmailAddress'
                    ),
			),
		));
	}
}