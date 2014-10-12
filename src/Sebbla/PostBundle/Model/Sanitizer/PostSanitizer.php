<?php

namespace Sebbla\PostBundle\Model\Sanitizer;

use Sebbla\PostBundle\Model\Sanitizer\AbstractSanitizer;

/**
 * Post sanitizer.
 */
class PostSanitizer extends AbstractSanitizer
{

    /**
     * Sanitizing Post object.
     * 
     * Remowing all tags from name and text.
     */
    public function sanitize()
    {
        $this->object->setName(\strip_tags($this->object->getName()));
        $this->object->setText(\strip_tags($this->object->getText()));
    }

}
