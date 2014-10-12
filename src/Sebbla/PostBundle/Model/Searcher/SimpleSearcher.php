<?php

namespace Sebbla\PostBundle\Model\Searcher;

use Sebbla\PostBundle\Model\Searcher\SearcherTypeInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Simple searcher.
 * 
 * This is the simplest possible search engine.
 * Real application should use dedicated search engine like sphinx, elasticsearch etc.
 * This search engine is simple but is very slow and it's only for presentation.
 */
class SimpleSearcher implements SearcherTypeInterface
{

    /**
     * Entity manager.
     * 
     * @var Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * Options.
     * 
     * @var array 
     */
    protected $options;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Returning results.
     * 
     * @return array
     */
    public function getResults()
    {
        $result = $this->em->getRepository('SebblaPostBundle:Post')->getPosts($this->options);

        return $result;
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
