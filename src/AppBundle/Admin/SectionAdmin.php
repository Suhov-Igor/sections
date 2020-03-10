<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Section;
use AppBundle\Entity\SectionPage;
use AppBundle\Form\Type\TableType;
use AppBundle\Form\Type\MessageType;

final class SectionAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $qb = $this->modelManager->getEntityManager(SectionPage::class)->createQueryBuilder();
        $expr = $this->modelManager->getEntityManager(SectionPage::class)->getExpressionBuilder();
        $qb->select('entity')
           ->from(SectionPage::class, 'entity')
           ->where($expr->eq('entity.section', "'".$this->subject->getId()."'"));

        $formMapper
            ->with('Section')
                ->add('name', TextType::class)
                ->add('slug', TextType::class)
            ->end()
            ->with('Pages');
            if (!$this->isCurrentRoute('create')) {
                $formMapper->add('sectionPages',  TableType::class,
                [
                    'query' => $qb->getQuery(),
                    'btn_add' => 'Add new page',
                    'label' => false,
                    'columnsLabel' => ['Name', 'Position'],
                    'columnsName' => ['name', 'position']
                ]);
            }
            else {
                $formMapper->add('sectionPages', MessageType::class, ['message' => 'Please save section before adding new page.', 'label' => false]);
            }
            $formMapper->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('slug');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('slug');
        $listMapper->add('name');
    }

    public function toString($object)
    {
        return $object instanceof Section
            ? $object->getName()
            : 'Section'; // shown in the breadcrumb on the create view
    }
}
