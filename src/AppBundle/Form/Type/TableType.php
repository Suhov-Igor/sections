<?php
namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager = null)
    {
        $this->entityManager = $entityManager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'query' => null,
            'btn_add' => null,
            'label' => null,
            'columnsLabel' => [],
            'columnsName' => [],
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['items'] = $options['query']->getResult();
        $view->vars['btn_add'] = $options['btn_add'];
        $view->vars['label'] = $options['label'];
        array_push($options['columnsLabel'], 'Actions');
        $view->vars['columnsLabel'] = $options['columnsLabel'];
        array_push($options['columnsName'], 'actions');
        $view->vars['columnsName'] = $options['columnsName'];
    }
}