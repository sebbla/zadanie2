<?php

namespace Sebbla\PostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sebbla\PostBundle\Model\PostChoiceList;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Choice;
use Sebbla\PostBundle\Entity\Post;

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
                ->add('name', 'text', array(
                    'label' => 'form.post.name',
                    'required' => true,
                    'translation_domain' => 'SebblaPostBundle',
                    'constraints' => array(
                        new NotBlank(array('message' => 'validation.postsearcher.name.notblank')),
                        new Length(array(
                            'min' => 3,
                            'max' => 1000,
                            'minMessage' => 'validation.postsearcher.name.length.min',
                            'maxMessage' => 'validation.postsearcher.name.length.max'
                        )),
                    ),
                ))
                ->add('type', 'choice', array(
                    'label' => 'form.post.type',
                    'translation_domain' => 'SebblaPostBundle',
                    'required' => false,
                    'choice_list' => new PostChoiceList(),
                    'constraints' => array(
                        new Choice(array(
                            'choices' => Post::getPostTypes(),
                            'message' => 'validation.postsearcher.type.choices'
                        ))
                    )
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
