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
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function index(User $user)
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findBy([], ['nom' => 'ASC']);

        return $this->render('user/index.html.twig', [
            'contacts' => $contacts,
            'user' => $user
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/compte/{id}", requirements={"id": "\d+"})
     */
    public function monCompte(Request $request, $id, User $user)
    {

//ALLER CHERCHER L ID DU USER DEJA CONNECTE
        $em = $this->getDoctrine()->getManager();
        $user = $em->find(User::class, $id);

        //AFFICH UN FORM

        $form =$this->createForm(UserCompleteType::class, $user);

        //VALID FORM???
        if ($form->isSubmitted()){

//        AFFICH UN MESS DE CONFIRM
        $this->addFlash('success','Votre profil a été mis a jour');

         return $this->redirectToRoute('app_user_index');
        }

        //LE METTRE EN BDD
        $form->handleRequest($request);

        $em->persist($user);
        $em->flush();

        return $this->render('user/compte.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
