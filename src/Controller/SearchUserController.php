<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchUserController
 * @package App\Controller
 *
 * @Route("/recherche")
 */
class SearchUserController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function searchUser(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()->getRepository(User::class);

        // formulaire de recherche
        $searchForm = $this->createForm(SearchUserType::class);

        $searchForm->handleRequest($request);

        $user = $repository->search((array)$searchForm->getData());

        return $this->render('search_user/searchUser.html.twig',
        [
            'search_form' => $searchForm->createView(),
            'users' => $user
        ]);
    }
}
