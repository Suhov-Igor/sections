<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Subscription;
use AppBundle\Entity\ExternalSocialNetworks;
use AppBundle\Entity\SocialNetwork;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\Type\TableType;
use AppBundle\Form\Type\MessageType;

final class BlockAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $qb = $this->modelManager->getEntityManager(SocialNetwork::class)->createQueryBuilder();
        $expr = $this->modelManager->getEntityManager(SocialNetwork::class)->getExpressionBuilder();
        $qb->select('entity')
           ->from(SocialNetwork::class, 'entity')
           ->where($expr->eq('entity.block', "'".$subject->getId()."'"));

        $formMapper
            ->with('Block')
                ->add('position', NumberType::class)
                ->add('page', ModelType::class, ['btn_add' => false])
            ->end();

        if ($subject instanceof Subscription) {
            $formMapper
                ->with('Subscription')
                    ->add('type', HiddenType::class, ['data' => 'subscription'])
                    ->add('title', TextType::class)
                    ->add('buttonTitle', TextType::class)
                ->end();
        }
        elseif ($subject instanceof ExternalSocialNetworks) {
            $formMapper
                ->with('Social Networks')
                ->add('type', HiddenType::class, ['data' => 'externalSocialNetworks']);
            if (!$this->isCurrentRoute('create')) {
                $formMapper
                    ->add('socialNetworks',  TableType::class,
                        [
                            'query' => $qb->getQuery(),
                            'btn_add' => 'Add new social network',
                            'label' => false,
                            'columnsLabel' => ['Link', 'Position'],
                            'columnsName' => ['link', 'position']
                        ]
                    );
            }
            else {
                $formMapper->add('socialNetworks', MessageType::class, ['message' => 'Please save block before adding new social network.', 'label' => false]);
            }
            $formMapper->end();
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        $listMapper->add('type');
        $listMapper->add('page');
        $listMapper->add('position');
    }

    public function toString($object)
    {
        return 'Block'; // shown in the breadcrumb on the create view
    }
}
