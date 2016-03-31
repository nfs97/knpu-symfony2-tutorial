<?php

namespace EventBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use EventBundle\Entity\Event;
use EventBundle\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="event")
     * @Template("EventBundle:Event:index.html.twig")
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {


        return array();
    }

    public function _upcomingEventsAction($max = null)
    {
        $em = $this->getDoctrine()->getManager();


        $events = $em->getRepository('EventBundle:Event')
            ->getUpcomingEvents($max);

        return $this->render('EventBundle:Event:_upcomingEvents.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * Creates a new Event entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();

        $event = new Event();
        $form = $this->createForm('EventBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $event->setOwner($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('EventBundle:Event:new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction(Event $entity, $slug)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('EventBundle:Event:show.html.twig', array(
            'slug' => $slug,
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction(Request $request, Event $entity)
    {
        $this->enforceUserSecurity();

        $this->enforceOwnerSecurity($entity);

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm('EventBundle\Form\EventType', $entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute('event_edit', array('id' => $entity->getId()));
        }

        return $this->render('EventBundle:Event:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction(Request $request, Event $event)
    {
        $this->enforceUserSecurity();

        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->enforceOwnerSecurity($event);
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event');
    }

    public function attendAction($id, $format)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);

        if(!$event){
            throw $this->createNotFoundException('Unable to find event');
        }

        if(!$event->hasAttendee($this->getUser())) {
            $event->getAttendees()->add($this->getUser());
        }
        $em->persist($event);
        $em->flush();

        return $this->createAttendingResponse($event, $format);
    }

    public function unattendAction($id, $format)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);

        if(!$event){
            throw $this->createNotFoundException('Unable to find event');
        }

        if($event->hasAttendee($this->getUser())) {
            $event->getAttendees()->removeElement($this->getUser());
        }
        $em->persist($event);
        $em->flush();

        return $this->createAttendingResponse($event, $format);
    }

    public function createAttendingResponse(Event $event, $format)
    {
        if($format == 'json'){
            $data = array(
                'attending' => $event->hasAttendee($this->getUser()),
            );
            $response = new JsonResponse($data);


            return $response;
        }

        $url = $this->generateUrl('event_show', array(
            'slug' => $event->getSlug()
        ));

        return $this->redirect($url);
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function enforceUserSecurity()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
    }

   
}
