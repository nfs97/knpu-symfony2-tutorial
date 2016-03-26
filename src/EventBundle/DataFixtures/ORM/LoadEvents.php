<?php
namespace EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use EventBundle\Entity\Event;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadEvents implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $wayne=$manager->getRepository('UserBundle:Users')
            ->findOneByUsernameOrEmail('wayne');

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

        $event1->setOwner($wayne);
        $event2->setOwner($wayne);

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}