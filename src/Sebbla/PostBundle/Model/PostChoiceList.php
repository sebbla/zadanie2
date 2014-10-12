<?php

namespace Sebbla\PostBundle\Model;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Sebbla\PostBundle\Entity\Post;

/**
 * Post choices list.
 */
class PostChoiceList extends LazyChoiceList
{

    /**
     * Returning available post types.
     * 
     * @return \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList
     */
    protected function loadChoiceList()
    {
        $data = Post::getPostTypes();

        return new \Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList($data, $data);
    }

}
