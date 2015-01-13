<?php

namespace AK\Bundle\WordLearnerBundle\Controller;

use AK\Bundle\WordLearnerBundle\Entity\Chapter;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AK\Bundle\WordLearnerBundle\Entity\Phrase;
use AK\Bundle\WordLearnerBundle\Form\PhraseType;

/**
 * Phrase controller.
 *
 * @Route("/phrase")
 */
class PhraseController extends Controller
{

    /**
     * Lists all Phrase entities.
     *
     * @Route("/", name="phrase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AKWordLearnerBundle:Phrase')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Phrase entity.
     *
     * @Route("/", name="phrase_create")
     * @Method("POST")
     * @Template("AKWordLearnerBundle:Phrase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Phrase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $button = $form->get('create_and_new');
            if ($button instanceof ClickableInterface && $button->isClicked()) {
                $route = $this->generateUrl('phrase_new', ['chapter' => $entity->getChapter()->getId()]);
            } else {
                $route = $this->generateUrl('phrase_show', ['id' => $entity->getId()]);
            }

            $result = $this->redirect($route);
        } else {
            $result = array(
                'entity' => $entity,
                'form'   => $form->createView(),
            );
        }

        return $result;
    }

    /**
     * Creates a form to create a Phrase entity.
     *
     * @param Phrase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Phrase $entity)
    {
        $form = $this->createForm(new PhraseType(), $entity, array(
            'action' => $this->generateUrl('phrase_create'),
            'method' => 'POST',
        ));

        $form->add('create', 'submit', array('label' => 'Create'));
        $form->add('create_and_new', 'submit', array('label' => 'Create and new'));

        return $form;
    }

    /**
     * Displays a form to create a new Phrase entity.
     *
     * @param Chapter $chapter
     *
     * @return array
     *
     * @Route("/new/{chapter}", name="phrase_new", defaults={"chapter"=null})
     * @Method("GET")
     * @Template()
     */
    public function newAction(Chapter $chapter = null)
    {
        $entity = new Phrase();
        $entity->setChapter($chapter);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Phrase entity.
     *
     * @Route("/{id}", name="phrase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AKWordLearnerBundle:Phrase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phrase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Phrase entity.
     *
     * @Route("/{id}/edit", name="phrase_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AKWordLearnerBundle:Phrase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phrase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Phrase entity.
    *
    * @param Phrase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Phrase $entity)
    {
        $form = $this->createForm(new PhraseType(), $entity, array(
            'action' => $this->generateUrl('phrase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Phrase entity.
     *
     * @Route("/{id}", name="phrase_update")
     * @Method("PUT")
     * @Template("AKWordLearnerBundle:Phrase:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AKWordLearnerBundle:Phrase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phrase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('phrase_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Phrase entity.
     *
     * @Route("/{id}", name="phrase_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AKWordLearnerBundle:Phrase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Phrase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('phrase'));
    }

    /**
     * Creates a form to delete a Phrase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phrase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
