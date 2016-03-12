<?php
namespace EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use EventBundle\Entity\Event;

class LoadEvents implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Darth surprise bithday party and the guest is');
        $event1->setLocation("DeathStar");
        $event1->setTime(new \DateTime('2000-01-01'));
        $event1->setDetails('Ha! Darth hates surprises!!! But give him presents');

        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('Luke Skywalker ');
        $event2->setLocation("Yavin");
        $event2->setTime(new \DateTime('2005-07-04'));
        $event2->setDetails('Get there faster than I can do it');
        $manager->persist($event2);

        $manager->flush();
    }
}