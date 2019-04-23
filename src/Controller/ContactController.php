<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function createContact(Request $request, $id = '')
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
            if ($form->isValid()){

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
                }  else{
                    $this->addFlash('error','Email déjà existant, votre contact doit avoir un email différent');
                }
        }


        return $this->render('contact/createContact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modification/{id}", requirements={"id": "\d+"})
     */
    public function editContact(Request $request, $id) {

        /** Vérifie si l'utilisateur est authentifié */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        $contact = $em->find(Contact::class, $id);

        $originalPhoto = null;

        if (is_null($contact)) {
            throw new NotFoundHttpException();
        }

        if (!is_null($contact->getPhoto())) {
            // nom du fichier venant de la bdd
            $originalPhoto = $contact->getPhoto();

            // on sette l'image avec un objet File sur l'emplacement de l'image
            // pour le traitement par le formulaire
            $contact->setPhoto(
                new File($this->getParameter('upload_dir') . $originalPhoto)
            );
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $photo = $contact->getPhoto();

            // s'il y a eu une image uploadée
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

                // en modification on supprime l'ancienne image
                // s'il y en a une
                if (!is_null($originalPhoto)) {
                    unlink($this->getParameter('upload_dir') . $originalPhoto);
                }
            } else {
                // en modification, sans upload, on sette l'attribut image
                // avec le nom de l'ancienne image
                $contact->setPhoto($originalPhoto);
            }

            //LE METTRE EN BDD

            $em->persist($contact);
            $em->flush();

//        AFFICH UN MESS DE CONFIRM
            $this->addFlash('success','Votre contact a été modifié !');

            return $this->redirectToRoute('app_user_listcontact');
        } else {
            $this->addFlash('error', 'Le formulaire contient des erreurs');
        }

        return $this->render('contact/editContact.html.twig',
            [
                'form' => $form->createView(),
                'original_photo' => $originalPhoto,
                'contact' => $contact
            ]
        );
    }

    /**
     * @Route("/suppression/{id}", requirements={"id": "\d+"})
     */
    public function deleteContact(Contact $contact)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        // si le contact a une image, on la supprime
        /**if (!is_null($contact->getPhoto())) {
            unlink($this->getParameter('upload_dir') . $contact->getPhoto());
        }*/

        $em->remove($contact);
        $em->flush();

        $this->addFlash('success', "Le contact est supprimé !");

        return $this->redirectToRoute('app_user_listcontact');
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function ficheContact(Request $request, $id)
    {

        $repository = $this->getDoctrine()->getRepository(Contact::class);

        $contact = $repository->findBy(['id' => $id]);

        return $this->render('contact/ficheContact.html.twig',
            [
                'contact' => $contact
            ]
        );
    }


    /**
     * @Route("ajout/{id}", requirements={"id": "\d+"})
     */
    public function addContact(Request $request, $id)
    {
        /** Vérifie si l'utilisateur est authentifié */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();

        $user = $em->find(User::class, $id);

        $originalPhoto = null;

        $contact = new Contact();

        $contact
            ->setPrenom($user->getFirstname())
            ->setNom($user->getLastname())
            ->setTelephone($user->getPhone())
            ->setEmail($user->getEmail())
            ->setAdresse($user->getAdress())
            ->setCodePostal($user->getPostalCode())
            ->setVille($user->getCity())
            ->setDateDeNaissance($user->getDateBirth())
            ->setPhoto($user->getPhoto())
            ->setProfession($user->getEmploi())
            ->setUser($this->getUser())
        ;

        if (is_null($contact)) {
            throw new NotFoundHttpException();
        }

        if (!is_null($contact->getPhoto())) {
            // nom du fichier venant de la bdd
            $originalPhoto = $contact->getPhoto();

            // on sette l'image avec un objet File sur l'emplacement de l'image
            // pour le traitement par le formulaire
            $contact->setPhoto(
                new File($this->getParameter('upload_dir') . $originalPhoto)
            );
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()){

            if($form->isValid()){

                $photo = $contact->getPhoto();

                // s'il y a eu une image uploadée
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

                    // en modification on supprime l'ancienne image
                    // s'il y en a une
                    if (!is_null($originalPhoto)) {
                        unlink($this->getParameter('upload_dir') . $originalPhoto);
                    }
                } else {
                    // en modification, sans upload, on sette l'attribut image
                    // avec le nom de l'ancienne image
                    $contact->setPhoto($originalPhoto);
                }

                //LE METTRE EN BDD

                $em->persist($contact);
                $em->flush();

//        AFFICH UN MESS DE CONFIRM
                $this->addFlash('success','Votre contact a été ajouté !');

                return $this->redirectToRoute('app_user_listcontact');
            }
            else
            {
                $this->addFlash('error','Un email identique est présent dans votre liste de contacts');
            }
        } else {
            $this->addFlash('error', 'Le formulaire contient des erreurs');
        }

        return $this->render('contact/addContact.html.twig',
            [
                'form' => $form->createView(),
                'original_photo' => $originalPhoto,
                'contact' => $contact
            ]
        );
    }



}
