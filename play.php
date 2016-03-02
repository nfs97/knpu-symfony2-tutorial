<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__ . '/app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();

$templating = $container->get('templating');


use EventBundle\Entity\Event;

$event = new Event();
$event->setName('Darth\'s surprise bithday party');
$event->setLocation("DeathStar");
$event->setTime(new \DateTime('tomorrow soon'));
$event->setDetails('Ha! Darth hates surprises!!!');

$em=$container->get('doctrine')->getManager();
$em->persist();

