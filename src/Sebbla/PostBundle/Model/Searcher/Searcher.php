<?php

namespace Sebbla\PostBundle\Model\Searcher;

use Sebbla\PostBundle\Model\Searcher\AbstractSearcher;
use Sebbla\PostBundle\Model\Searcher\SearcherTypeInterface;

/**
 * Searcher service.
 */
class Searcher extends AbstractSearcher
{

    /**
     * Searcher type.
     * 
     * @var \Sebbla\PostBundle\Searcher\SearcherTypeInterface; 
     */
    private $searcherType;

    function __construct(SearcherTypeInterface $searcherType)
    {
        $this->searcherType = $searcherType;
    }

    /**
     * Returning results.
     * 
     * @return mixed
     */
    public function getResults()
    {
        $this->searcherType->setOptions($this->options);

        return $this->searcherType->getResults();
    }

}
