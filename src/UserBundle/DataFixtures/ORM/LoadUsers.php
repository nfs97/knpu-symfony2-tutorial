<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Users;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadUsers implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {


        $user = new Users();
        $user->setUsername('darth');
        $user->setEmail('darth@darth.com');
        $user->setIsActive(true);
        $user->setPassword($this->encodePassword($user,'darthpass'));
        $manager->persist($user);

        $admin = new Users();
        $admin->setUsername('wayne');
        $admin->setEmail('wayne@darth.com');
        $admin->setIsActive(true);
        $admin->setPassword($this->encodePassword($admin,'waynepass'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $manager->flush();
    }

    private function encodePassword(Users $user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        return $encoded;

    }

    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;
    }

    public function getOrder()
    {
        return 10;
    }

}