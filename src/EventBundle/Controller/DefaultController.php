<?php

namespace EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EventBundle\Entity\Event;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    /*public function indexAction($name, $count)
    {
        return $this->render(
            'EventBundle:Default:index.html.twig',
            array('name' => $name, 'count' => $count)
        );
    }*/


    public function indexAction($name, $count)
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
    }
}


