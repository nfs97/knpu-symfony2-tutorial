<?php


namespace UserBundle\Controller;

use EventBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    /**
     *@Route("/login", name="login_form")
     * @Template
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);


        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        //Nothing!!!
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        //Nothing!!!
    }
}