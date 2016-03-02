<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Doctrine\ORM\EntityManager;

/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__ . '/app/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

$container = $kernel->getContainer();

use EventBundle\Entity\Event;

$event = new Event();
$event->setName('Darth\'s surprise bithday party');
$event->setLocation("DeathStar");
$event->setTime(new \DateTime('tomorrow soon'));
$event->setDetails('Ha! Darth hates surprises!!!');

