<?php

namespace Sebbla\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Portal controller.
 *
 * @Route("/")
 */
class PortalController extends Controller
{

    /**
     * Homepage.
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function homepageAction()
    {
        return $this->redirect($this->generateUrl('post'));
    }

}
