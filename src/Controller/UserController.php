<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\UserCompleteType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        //AFFICH UN FORM

        $form =$this->createForm(UserCompleteType::class, $user);

        //VALID FORM???
        if ($form->isSubmitted()){

            //LE METTRE EN BDD
            $form->handleRequest($request);

            $em->persist($user);
            $em->flush();

//        AFFICH UN MESS DE CONFIRM
        $this->addFlash('success','Votre profil a été mis a jour');

         return $this->redirectToRoute('app_user_moncompte');
        }



        return $this->render('user/compte.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil")
     */
    public function profilUser()
    {
        return $this->render('user/profil.html.twig');
    }

}
