<?php
namespace Car\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter;
use Zend\Validator;

class CarForm extends Form
{
    protected $_dir;

    public function __construct($dir, $name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->_dir = $dir;

        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $this->add(array(
            'name' => 'brand',
            'required' => true,
            'attributes' => array(
                'class' => 'span4',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Бренд',
            ),
        ));

        $this->add(array(
            'name' => 'name_model',
            'required' => true,
            'attributes' => array(
                'class' => 'span4',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Модель',
            ),
        ));

        $this->add(array(
            'name' => 'detail',
            'required' => true,
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'span4',
                'rows' => '10'
            ),
            'options' => array(
                'label' => 'Детальное описание',
            ),
        ));

        // File Input
        $file = new Element\File('photo');
        $file->setLabel('Добавить изображение')
            ->setAttribute('id', 'photo');
        $this->add($file);
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
        // File Input
        $fileInput = new InputFilter\FileInput('photo');
        $fileInput->setRequired(false);
//        $fileInput->getValidatorChain()
//            ->attachByName('filesize',      array('max' => 204800))
//            ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png'))
//            ->attachByName('fileimagesize', array('maxWidth' => 100, 'maxHeight' => 100));
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target' => $this->_dir,
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}
