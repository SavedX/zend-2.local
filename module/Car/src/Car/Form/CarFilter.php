<?php
namespace Car\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class CarFilter extends InputFilter
{
	public function __construct($sm)
	{
		$this->add(array(
			'name'     => 'brand',
			'required' => true,
			'validators' => array(
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'      => 3,
						'max'      => 100,
					),
				),
			),
		));

        $this->add(array(
            'name'     => 'name_model',
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
            'name'     => 'detail',
            'required' => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 3,
                        'max'      => 1024,
                    ),
                ),
            ),
        ));
//        $this->add(array(
//            'name'     => 'photo',
//            'required' => true,
//            'validators' => array(
//                array(
//                    'name'    => 'StringLength',
//                    'options' => array(
//                        'encoding' => 'UTF-8',
//                        'min'      => 1,
//                        'max'      => 100,
//                    ),
//                ),
//            ),
//        ));

	}
}