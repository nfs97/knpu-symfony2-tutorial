<?php


namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EventBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Users;
use UserBundle\Form\RegisterFormType;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {

        $user = new Users();
        $user->setUsername('Leia');

        $form = $this->createForm(RegisterFormType::class, $user);

        $form->handleRequest($request);
        if($form->isValid()){
            $user = $form->getData();



            $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Welcome to Death Star! Have a great day!'
            );

            $url = $this->generateUrl('/');

            return $this->redirect($url);
        }

        return array('form' => $form->createView());
    }

    private function encodePassword(Users $user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        return $encoded;

    }
}