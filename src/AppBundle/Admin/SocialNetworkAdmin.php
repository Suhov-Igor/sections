<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Block;
use AppBundle\Entity\ExternalSocialNetworks;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints\File;

final class SocialNetworkAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $webPath = $this->getSubject()->getIconUrl();
        $container = $this->getConfigurationPool()->getContainer();
        $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
        $iconUrlHelp = '<img src="'.$fullPath.'" class="img-thumbnail rounded float-left"/>';

        $formMapper
            ->with('Social Network')
                ->add('link', UrlType::class)
                ->add('file', FileType::class, [
                'label' => 'Icon Url',
                'help' => $iconUrlHelp,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                    ])
                ]]);
        if ($this->isCurrentRoute('create')) {
            $formMapper->add('block', EntityType::class, ['class' => ExternalSocialNetworks::class, 'expanded' => true]);
        }
        $formMapper->add('position', NumberType::class)
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('link');
        $listMapper->add('iconUrl');
        $listMapper->add('position');
    }

    public function toString($object)
    {
        return 'Social Network'; // shown in the breadcrumb on the create view
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SocialNetwork::class,
        ]);
    }
}
