<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\User;
use App\Form\ChatType;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/chat/{id}")
     */
    public function chat( Request $request, User $userRecoit)
    {

        //$form = $this->createForm(ChatType::class);

        //$form->get('message_to')->setData($userRecoit->getId());



        return $this->render(
            'index/chat.html.twig',
            [
                'user_id' => $userRecoit->getId()
            ]
            //['form' => $form->createView()]
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
        $message->setContent($request->request->get('content'));

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
        $session = $request->getSession();

        if (!$session->has('last_message')) {
            $minId = null;
        } else {
            $minId = $session->get('last_message');
        }

        $em = $this->getDoctrine()->getManager();
        $user1 = $this->getUser();
        $user2 = $em->find(User::class, $request->query->get('user'));

        $messages = $em->getRepository(Messages::class)->getLastMessages($user1, $user2, $minId);

        $response= ' ';

        foreach ($messages as $message){
            $response .='<span>'.$message->getcontent().'</span>';
        }

        return new Response($response);

    }
}
