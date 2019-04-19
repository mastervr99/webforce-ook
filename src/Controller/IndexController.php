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

        //POUR REPARTIR DE LA PAGE CHAT DE ZERO SANS MESS D UNE PRECEDENTE SESSION
        $session = $request->getSession();

        $session->remove("last_message");


        return $this->render(
            'index/chat.html.twig',
            [
                'user_id' => $userRecoit->getId()
            ]
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

//        SI LA SESSION A UN LAST MESS
//        LA SI ELLE N A PAS DE LAST MESS ALORS MINID VAUT NULL ELSE IL VA CHERCHER MES LAST MESS
        if (!$session->has('last_message')) {
            $minId = null;
        } else {
            $minId = $session->get('last_message');
        }

        $em = $this->getDoctrine()->getManager();
        $user1 = $this->getUser();
        $user2 = $em->find(User::class, $request->query->get('user'));

        $messages = $em->getRepository(Messages::class)->getLastMessages($user1, $user2, $minId);

        $response = '';

        //BOUCLE PR AFFICH UN MESS DS MESSAGES DRACE AU METH DE MON REPOSITORY
        foreach ($messages as $message) {
            //RECUPERER L ID DU USER1 PR AFFICH SON MESS A DROITE
            if ($message->getUserEnvoi()->getId() == $this->getUser()->getId()) {
                $response .= '<p class="text-right">' . $message->getContent() . '</p><hr>';
                //L AUTRE USER AURA SON TEXT PAR DEFAULT A GAUCHE
            } else {
                $response .= '<span>' . $message->getContent() . '</span><hr>';
            }
        }

//        DEFINIR LAST MESS PAR RAPPORT AU DERNIER ID MESS QUIL A RECU
//        SI IL NE RECOIT AUCUN MESS LA BOUCLE NE FAIS AUCUN TOUR ET DONC $MESSAGE N EXISTE PAS
        if (isset($message)) {
            $session->set('last_message', $message->getId());
        }

        return new Response($response);
    }

}
