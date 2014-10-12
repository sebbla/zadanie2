<?php

namespace Sebbla\PostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sebbla\PostBundle\Model\PostChoiceList;

/**
 * Post search type.
 */
class PostSearchType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array('label' => 'form.post.name', 'translation_domain' => 'SebblaPostBundle'))
                ->add('type', 'choice', array(
                    'label' => 'form.post.type',
                    'translation_domain' => 'SebblaPostBundle',
                    'required' => false,
                    'choice_list' => new PostChoiceList(),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sebbla_postbundle_searchpost';
    }

}
