<?php

namespace EventBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EventBundle\Entity\Event;
//use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    public function indexAction($name, $count)
    {
        /*$event = new Event();
        $event->setName('Darth surprise bithday party and the guest is');
        $event->setLocation("DeathStar");
        $event->setTime(new \DateTime('2000-01-01'));
        $event->setDetails('Ha! Darth hates surprises!!! But give him presents');*/

        $em = $this->getDoctrine()->getManager();

        /*$em->persist($event);
        $em->flush();*/

        $repo = $em->getRepository('EventBundle:Event');

        $event =  $repo->find(11);

        return $this->render(
            'EventBundle:Default:index.html.twig',
            array('name' => $name, 'count' => $count, 'event' => $event)
        );
        //return new Response('The location is'.$event->getLocation());
    }


    /*public function indexAction($name, $count)
    {
        $event = new Event();
        $event->setName('Darth\'s surprise bithday party and the guest is '.$name);
        $event->setLocation("DeathStar");
        $event->setTime(new \DateTime('2000-01-01'));
        $event->setDetails('Ha! Darth hates surprises!!! But give him '.$count.' presents');

        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return new Response('Created new Event id '. $event->getId());
    }*/
}


