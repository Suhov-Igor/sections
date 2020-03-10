<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Page;
use AppBundle\Entity\Block;
use AppBundle\Form\Type\TableType;
use AppBundle\Form\Type\MessageType;

final class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $qb = $this->modelManager->getEntityManager(Block::class)->createQueryBuilder();
        $expr = $this->modelManager->getEntityManager(Block::class)->getExpressionBuilder();
        $qb->select('entity')
           ->from(Block::class, 'entity')
           ->where($expr->eq('entity.page', "'".$this->subject->getId()."'"));

        $formMapper
            ->with('Page')
                ->add('name', TextType::class)
                ->add('slug', TextType::class)
            ->end();

        $formMapper->with('Blocks');
        if (!$this->isCurrentRoute('create')) {
            $formMapper->add('blocks',  TableType::class,
                [
                    'query' => $qb->getQuery(),
                    'btn_add' => 'Add new block',
                    'label' => false,
                    'columnsLabel' => ['Type', 'Position'],
                    'columnsName' => ['type', 'position']
                ]
            );
        }
        else {
            $formMapper->add('blocks', MessageType::class, ['message' => 'Please save page before adding new blocks.', 'label' => false]);
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
        return $object instanceof Page
            ? $object->getName()
            : 'Page'; // shown in the breadcrumb on the create view
    }
}
