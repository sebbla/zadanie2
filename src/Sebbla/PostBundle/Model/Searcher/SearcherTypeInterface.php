<?php

namespace Sebbla\PostBundle\Model\Searcher;

/**
 * Searcher type interface.
 */
interface SearcherTypeInterface
{

    /**
     * Returning results.
     */
    public function getResults();
}
