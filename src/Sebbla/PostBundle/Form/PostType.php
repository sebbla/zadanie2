<?php

namespace Sebbla\PostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Post type.
 */
class PostType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array('label' => 'form.post.name', 'translation_domain' => 'SebblaPostBundle'))
                ->add('text', 'textarea', array('label' => 'form.post.text', 'translation_domain' => 'SebblaPostBundle'))
                ->add('image', 'file', array('required' => false, 'label' => 'form.post.image', 'translation_domain' => 'SebblaPostBundle'))
                ->add('type', 'choice', array(
                    'label' => 'form.post.type',
                    'translation_domain' => 'SebblaPostBundle',
                    'required' => true,
                    'choice_list' => new \Sebbla\PostBundle\Model\PostChoiceList()
                ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sebbla\PostBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sebbla_postbundle_post';
    }

}
