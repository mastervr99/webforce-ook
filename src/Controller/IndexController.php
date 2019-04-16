<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\User;
use App\Form\ChatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("chat/{id}")
     */
    public function chat( Request $request, User $userRecoit)
    {

        $form = $this->createForm(ChatType::class);

        $form->get('message_to')->setData($userRecoit->getId());


        return $this->render(
            'index/chat.html.twig',
            ['form' => $form->createView()]
        );

    }

    /**
     * @Route("/ajout-message")
     */
    public function ajoutMessage(Request $request)
    {
//        A QUI ON L ENVOI
        $em = $this->getDoctrine()->getManager();

        $userId = $request->request->get('message_to');

        $userRecoit = $em->find(User::class, $userId);

//PAREIL QU EN AJAX AJOUT-MESSAGE.PHP
        $message= new Messages();
        $message->setDatePublication(new \DateTime());
        $message->setUserEnvoi($this->getUser());
        $message->setUserRecoit($userRecoit);
        $message->setContent($request->request->get('user_envoi'));

        $em->persist($message);
        $em->flush();

//        A BESOIN D UN RETURN MEME SI ON NE S EN SERT PAS EXCEPTION LE LOGOUT
        return new Response('ok');
    }

    /**
     * @Route("/chat-messages")
     */
    public function chatMessages(Request $request)
    {
        $user1 = $request->query->get('user_envoi');
        $user2 = $request->query->get('user_reçoit');

        // find sur les 2 users

        $repository = $this->getDoctrine()->getRepository(User::class);

        $sender = $repository->

        // appel à la méthode getLastMessages() de messageRepository
        // en lui passant les 2 user

    }
}
