<?php


namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ObjectProperty;

class RegisterRepository extends Form
{
    public function __construct()
    {
        parent::__construct('register_repository');

        $this->setAttribute('method', 'post')
            ->setHydrator(new ObjectProperty())
            ->setInputFilter(new InputFilter);

        $this->add([
            'type' => RepositoryFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'register'
            ]
        ]);
    }

}