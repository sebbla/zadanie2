<?php

namespace Sebbla\PostBundle\Model\Searcher;

/**
 * Abstract searcher class.
 */
class AbstractSearcher
{

    /**
     * Searching options.
     * 
     * @var array
     */
    protected $options;

    /**
     * Returning options.
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Setting options.
     * 
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

}
