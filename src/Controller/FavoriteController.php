<?php


namespace App\Controller;


use App\Form\GifForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gif;
use Symfony\Component\Security\Core\Security;

class FavoriteController extends AbstractController
{

    /**
     * @Route("/fav/{id}/add", name="app_fav_add")
     * @param Gif $gif
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function add(Gif $gif, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $user->addFavorite($gif);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_album_list');
    }

    /**
     * @Route("/fav/{id}/delete", name="app_fav_delete")
     * @param Gif $gif
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Gif $gif, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $user->removeFavorite($gif);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_album_list');
    }
}