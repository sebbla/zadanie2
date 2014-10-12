<?php

namespace Sebbla\PostBundle\Model\Sanitizer;

use Sebbla\PostBundle\Model\Sanitizer\SanitizerInterface;

/**
 * Abstract sanitizer.
 */
abstract class AbstractSanitizer implements SanitizerInterface
{

    /**
     * Object to sanitize.
     * 
     * @var object 
     */
    protected $object;

    /**
     * Returning object.
     * 
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Setting object.
     * 
     * @param object $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

}
