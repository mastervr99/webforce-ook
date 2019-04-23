<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\UserCompleteType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/utilisateur")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/contact")
     */
    public function listContact(Request $request)
    {
        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Contact::class);

        $search = $request->query->get('search');

        if($search){
            $contacts = $repository->globalSearch($search);
        } else
        {
            $contacts = $repository->findBy(['user' => $user], ['nom' => 'ASC']);
        }

        return $this->render('user/listContact.html.twig', [
            'contacts' => $contacts,
            'user' => $user

        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/compte")
     */
    public function monCompte(Request $request)
    {
        $user = $this->getUser();

//ALLER CHERCHER L ID DU USER DEJA CONNECTE
        $em = $this->getDoctrine()->getManager();

        $originalPhoto = null;

        if (!is_null($user->getPhoto())) {
            // nom du fichier venant de la bdd
            $originalPhoto = $user->getPhoto();

            
            // on sette l'image avec un objet File sur l'emplacement de l'image
            // pour le traitement par le formulaire
            $user->setPhoto(
                new File($this->getParameter('upload_dir') . $originalPhoto)
            );
        }

        //AFFICH UN FORM

        $form =$this->createForm(UserCompleteType::class, $user);

        $form->handleRequest($request);

        //VALID FORM???
        if ($form->isSubmitted()){

            //LE METTRE EN BDD

            $photo = $user->getPhoto();

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
                $user->setPhoto($filename);


                // en modification on supprime l'ancienne image
                // s'il y en a une
                if (!is_null($originalPhoto)) {
                    unlink($this->getParameter('upload_dir') . $originalPhoto);
                }
            } else {
                // en modification, sans upload, on sette l'attribut image
                // avec le nom de l'ancienne image
                $user->setPhoto($originalPhoto);
            }

            $em->persist($user);
            $em->flush();

    //        AFFICH UN MESS DE CONFIRM
            $this->addFlash('success','Votre profil a été mis a jour');

             return $this->redirectToRoute('app_user_listcontact');
        }



        return $this->render('user/compte.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/profil/{id}", requirements={"id" = "\d+"})
     */
    public function profilUser(Request $request, User $user)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $contacts = $repository->findBy(['id' => $user]);

        return $this->render('user/profil.html.twig',
            [
                'user' => $user
            ]
        );
    }

}
