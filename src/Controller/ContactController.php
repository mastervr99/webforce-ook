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

        if (!is_null($contact->getPhoto())) {
            // nom du fichier venant de la bdd
            $photo = $contact->getPhoto();

            // on sette l'image avec un objet File sur l'emplacement de l'image
            // pour le traitement par le formulaire
            $contact->setPhoto(
                new File($this->getParameter('upload_dir') . $photo)
            );
        }

        //AFFICH UN FORM
        $form =$this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        //VALID FORM???
        if ($form->isSubmitted()){

            $contact
                ->setUser($this->getUser())
            ;

            $photo = $contact->getPhoto();

            if (!is_null($photo)) {
                // nom sous lequel on va enregistrer l'image
                $filename = uniqid() . '.' . $photo->guessExtension();

                // déplace l'image uploadée
                $photo->move(
                // vers le répertoire /public/photo
                // cf config/services.yaml
                    $this->getParameter('upload_dir'),
                    // nom du fichier
                    $filename
                );

                // on sette l'attribut image de l'article avec son nom
                // pour enregistrement en bdd
                $contact->setPhoto($filename);
            }

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
