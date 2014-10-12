<?php

namespace Sebbla\PostBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sebbla\PostBundle\Entity\Post;
use Sebbla\PostBundle\Form\PostSearchType;

/**
 * Searcher controller.
 *
 * @Route("/searcher")
 */
class SearcherController extends Controller
{

    /**
     * Searcher.
     * 
     * Only posts searching is implemented that is why we redirecting to
     * post searcher.
     *
     * @Route("/", name="searcher")
     * @Method("GET")
     * @Template()
     */
    public function searcherAction()
    {
        return $this->redirect($this->generateUrl('post_searcher'));
    }

    /**
     * Showing post searching form.
     *
     * @Route("/post", name="post_searcher")
     * @Method("GET")
     * @Template()
     */
    public function postSearcherAction()
    {
        $form = $this->createPostSearchForm();

        return array('form' => $form->createView(),);
    }

    /**
     * Searching for post and returning results.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @Route("/post", name="post_search")
     * @Method("POST")
     * @Template("SebblaPostBundle:Searcher:postSearchResults.html.twig")
     */
    public function postSearchAction(Request $request)
    {
        $form = $this->createPostSearchForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $searcher = $this->get('sebbla_post.searcher');
            $searcher->setOptions($data);
            $results = $searcher->getResults();

            return array('results' => $results);
        }

        return $this->render('SebblaPostBundle:Searcher:postSearcher.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a post search form.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPostSearchForm()
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new PostSearchType(), null, array(
            'action' => $this->generateUrl('post_search'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => $translator->trans('search.search', array(), 'SebblaPostBundle')));

        return $form;
    }

}
