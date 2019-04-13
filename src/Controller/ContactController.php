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
    public function createContact(Request $request)
    {
        /** Vérifie si l'utilisateur est authentifié */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        $contact = new Contact();

        //AFFICH UN FORM

        $form =$this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        //VALID FORM???
        if ($form->isSubmitted()){

            $contact
                ->setUser($this->getUser())
            ;

            //LE METTRE EN BDD

            $em->persist($contact);
            $em->flush();

//        AFFICH UN MESS DE CONFIRM
            $this->addFlash('success','Votre contact a été créé !');

            return $this->redirectToRoute('app_user_listcontact');
        }



        return $this->render('contact/createContact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
