<?php


namespace Application\Form;


use Application\Model\Repository;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ObjectProperty;

class RepositoryFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('repository');

        $this
            ->setHydrator(new ObjectProperty())
            ->setObject(new Repository())
        ;

        $this->add(array(
            'name' => 'url',
            'options' => array(
                'label' => 'Repository URL',
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
                'id' => 'repositoryUrl',
                'placeholder' => 'git@your.git.host.com:vendor/repository.git'
            ),
        ));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'url' => [
                'required' => true
            ]
        ];
    }
}