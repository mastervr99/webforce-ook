<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ChatUserController
 * @package App\Controller
 *
 * @Route("/chat/user", name="chat_user")
 */
class ChatUserController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('chat_user/chatUser.html.twig', [
            'controller_name' => 'ChatUserController',
        ]);
    }
}
