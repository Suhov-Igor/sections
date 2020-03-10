<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\AdminBundle\Form\Type\ModelType;


final class SectionPageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('Add page')
        ->add('section', ModelType::class, ['btn_add' => false])
        ->add('page', ModelType::class, ['btn_add' => false])
        ->add('position', NumberType::class)
        ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('page');
        $listMapper->add('section');
        $listMapper->add('position');
    }

    public function toString($object)
    {
        return 'Add page'; // shown in the breadcrumb on the create view
    }
}
