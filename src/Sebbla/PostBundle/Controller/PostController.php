<?php

namespace Sebbla\PostBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sebbla\PostBundle\Entity\Post;
use Sebbla\PostBundle\Form\PostType;

/**
 * Post controller.
 *
 * @Route("/post")
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $postQuery = $em->getRepository('SebblaPostBundle:Post')->findAllQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($postQuery, $this->get('request')->query->get('page', 1), 20);

        return array('pagination' => $pagination);
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/", name="post_create")
     * @Method("POST")
     * @Template("SebblaPostBundle:Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createCreateForm($post);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('id' => $post->getId())));
        }

        return array(
            'post' => $post,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $post = new Post();
        $form = $this->createCreateForm($post);

        return array(
            'post' => $post,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $translator = $this->get('translator');
        $post = $em->getRepository('SebblaPostBundle:Post')->find($id);
        if (!$post) {
            throw $this->createNotFoundException($translator->trans('post.notfound', array(), 'SebblaPostBundle'));
        }
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $translator = $this->get('translator');
        $post = $em->getRepository('SebblaPostBundle:Post')->find($id);
        if (!$post) {
            throw $this->createNotFoundException($translator->trans('post.notfound', array(), 'SebblaPostBundle'));
        }
        $editForm = $this->createEditForm($post);

        return array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}", name="post_update")
     * @Method("PUT")
     * @Template("SebblaPostBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $translator = $this->get('translator');
        $post = $em->getRepository('SebblaPostBundle:Post')->find($id);
        if (!$post) {
            throw $this->createNotFoundException($translator->trans('post.notfound', array(), 'SebblaPostBundle'));
        }
        $editForm = $this->createEditForm($post);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('id' => $id)));
        }

        return array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $translator = $this->get('translator');
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('SebblaPostBundle:Post')->find($id);
            if (!$post) {
                throw $this->createNotFoundException($translator->trans('post.notfound', array(), 'SebblaPostBundle'));
            }

            $em->remove($post);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Creates a form to edit a Post entity.
     *
     * @param Post $post The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Post $post)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new PostType(), $post, array(
            'action' => $this->generateUrl('post_update', array('id' => $post->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => $translator->trans('post.update', array(), 'SebblaPostBundle')));

        return $form;
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $post The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $post)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new PostType(), $post, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => $translator->trans('post.create', array(), 'SebblaPostBundle')));

        return $form;
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $translator = $this->get('translator');
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('post_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => $translator->trans('post.delete', array(), 'SebblaPostBundle')))
                        ->getForm()
        ;
    }

}
