<?php

namespace ApptooMemb\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use ApptooMemb\MemberBundle\Form\Type\ContactType;
use ApptooMemb\MemberBundle\Entity\Contact;
use ApptooMemb\MemberBundle\Form\MemberType;

class ProfileController extends Controller
{
	public function homeAction(Request $request)
	{
		$entManager = $this->getDoctrine()->getManager();

		$memberRepo = $entManager->getRepository("ApptooMembMemberBundle:Member");

		$username = $this->get('security.context')->getToken()->getUser();

		$member = $memberRepo->findByUser($username);

		if(null === $member) {
			throw new NotFoundHttpException("Membre introuvable !");
		}

		return $this->render("ApptooMembMemberBundle:Profile:index.html.twig", array(
			'member' => $member)
		);
	}

	public function contactAction(Request $request)
	{
		$entManager = $this->getDoctrine()->getManager();

		$memberRepo = $entManager->getRepository("ApptooMembMemberBundle:Member");
		$contactRepo = $entManager->getRepository("ApptooMembMemberBundle:Contact");

		$username = $this->get('security.context')->getToken()->getUser();

		$contactForm = $this->createFormBuilder(array())
			->add('contact', 'text')
			->add('add', 'submit')
			->getForm();

		if($request->isMethod('POST')) {
			$contactForm->bind($request);

			$currentMember = $memberRepo->find($memberRepo->findByUser($username)['id']);
			$contactToAdd = $memberRepo->find($memberRepo->getMemberId($contactForm->getData()['contact']));

			if(null !== $contactToAdd && $contactToAdd != $currentMember && !$contactRepo->isContact($currentMember, $contactToAdd)) {
				$contact = new Contact();

				$contact->setMember($currentMember);
				$contact->setContact($contactToAdd);

				$entManager->persist($contact);
				$entManager->flush();
			} else {
				$request->getSession()->getFlashBag()->add('error', 'Le contact ne peut être ajouté');
			}

			return $this->redirect($this->generateUrl('apptoo_memb_home'));
		}

		$listContact = $contactRepo->findBy(array('member' => $memberRepo->findByUser($username)['id']));

		return $this->render("ApptooMembMemberBundle:Profile:contact.html.twig", array(
			'contacts' => $listContact,
			'form' => $contactForm->createView()
		));
	}

	public function viewAction(Request $request, $idMember)
	{
		$entManager = $this->getDoctrine()->getManager();

		$memberRepo = $entManager->getRepository("ApptooMembMemberBundle:Member");

		$member = $memberRepo->findById($idMember);

		if(null === $member) {
			throw new NotFoundHttpException("Membre introuvable !");
		}

		return $this->render("ApptooMembMemberBundle:Profile:index.html.twig", array(
			'member' => $member)
		);
	}

	public function editAction(Request $request)
	{
		$entManager = $this->getDoctrine()->getManager();

		$username = $this->get('security.context')->getToken()->getUser();

		$memberRepo = $entManager->getRepository("ApptooMembMemberBundle:Member");

		$member = $memberRepo->find($memberRepo->findByUser($username)['id']);

		if(null === $member) {
			throw new NotFoundHttpException("Membre introuvable !");
		}

		$form = $this->createForm(new MemberType(), $member);

		if($form->handleRequest($request)->isValid()) {
			$entManager->flush();

			return $this->redirect($this->generateUrl('apptoo_memb_home'));
		}

		return $this->render('ApptooMembMemberBundle:Profile:editInfos.html.twig', array(
			'form' => $form->createView()));
	}

	public function deleteContactAction(Request $request, $id)
	{
		$entManager = $this->getDoctrine()->getManager();

		$contactRepo = $entManager->getRepository('ApptooMembMemberBundle:Contact');

		$entManager->remove($contactRepo->find($id));
		$entManager->flush();

		return $this->redirect($this->generateUrl('apptoo_memb_home'));
	}
}