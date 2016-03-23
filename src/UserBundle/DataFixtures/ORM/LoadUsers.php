<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Users;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


class LoadUsers implements FixtureInterface, ContainerAwareInterface
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

        $plainPassword = 'darthpass';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);

        $manager->persist($user);

        $manager->flush();
    }

    private function encodePassword(Users $user, $plainPassword)
    {

        $defaultEncoder = new MessageDigestPasswordEncoder('md5', true, 1);
        $encoders = array(
            'UserBundle\\Entity\\Users'                       => $defaultEncoder,
        );
        $encoderFactory = new EncoderFactory($encoders);
        $encoder = $encoderFactory->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());

    }

    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;
    }
}