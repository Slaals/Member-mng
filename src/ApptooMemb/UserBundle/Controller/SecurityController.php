<?php

namespace ApptooMemb\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{

	public function loginAction(Request $request)
	{
		if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirect($this->generateUrl('apptoo_memb_home'));
    	}

    	$session = $request->getSession();

    	if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
    		$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    	} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      		$session->remove(SecurityContext::AUTHENTICATION_ERROR);
    	}

    	return $this->render('ApptooMembUserBundle:Security:login.html.twig', array(
			'last_username' => $session->get(SecurityContext::LAST_USERNAME),
			'error'         => $error,
	    ));
	}
}