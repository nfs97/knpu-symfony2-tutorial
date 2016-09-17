<?php


namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use EventBundle\Entity\Event;

class Controller extends BaseController
{
    public function enforceOwnerSecurity(Event $event)
    {
        $user=$this->getUser();

        if ($user != $event->getOwner()){
            throw new AccessDeniedException('You don\'t own this');
        }
    }
}