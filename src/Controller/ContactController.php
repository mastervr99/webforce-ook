<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @package App\Controller
 *
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/creation")
     *
     */
    public function createContact(Request $request, $contact)
    {
        /** Vérifie si l'utilisateur est authentifié */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        //AFFICH UN FORM

        $form =$this->createForm(ContactType::class, $contact);

        //VALID FORM???
        if ($form->isSubmitted()){

            //LE METTRE EN BDD
            $form->handleRequest($request);

            $em->persist($contact);
            $em->flush();

//        AFFICH UN MESS DE CONFIRM
            $this->addFlash('success','Votre profil a été mis a jour');

            return $this->redirectToRoute('app_user_index');
        }



        return $this->render('contact/createContact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
