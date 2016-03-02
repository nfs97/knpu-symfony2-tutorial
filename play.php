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
$kernel->boot();

$container = $kernel->getContainer();

$templating = $container->get('templating');

echo $templating->render(
    'EventBundle:Default:index.html.twig',
    array('name'=>'Vader', 'count'=>10)
);

/*use EventBundle\Entity\Event;

$event = new Event();
$event->setName('Darth\'s surprise bithday party');
$event->setLocation("DeathStar");
$event->setTime(new \DateTime('tomorrow soon'));
$event->setDetails('Ha! Darth hates surprises!!!');
*/
