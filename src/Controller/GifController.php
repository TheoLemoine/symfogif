<?php


namespace App\Controller;


use App\Entity\Album;
use App\Form\GifForm;
use App\Form\SearchForm;
use App\Repository\GifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gif;

class GifController extends AbstractController
{

    /**
     * @Route("/album/{id<\d+>}/gif/add", name="app_gif_add")
     * @param Album $album
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function create(Album $album, Request $request, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $form = $this->createForm(GifForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $gif = $form->getData();
            $gif->setAuthor($user);

            $entityManager->persist($gif);
            $entityManager->flush();

            return $this->redirectToRoute('app_album_show', ['id' => $gif->getAlbum()->getId()]);
        }

        $form->get('album')->setData($album);

        return $this->render('gif/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/gif/{id<\d+>}/delete", name="app_gif_delete")
     * @param Gif $gif
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Gif $gif, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if($this->getUser()->getId() === $gif->getAuthor()->getId()) {
            $entityManager->remove($gif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_album_show', ['id' => $gif->getAlbum()->getId()]);
    }

    /**
     * @Route("/gif/search", name="app_gif_search")
     * @param GifRepository $repository
     * @param Request $request
     * @return Response
     */
    public function search(GifRepository $repository, Request $request)
    {
        $form = $this->createForm(SearchForm::class);
        $form->handleRequest($request);

        $results = [];
        $searchTerms = '';
        if($form->isSubmitted() && $form->isValid()) {
            $searchTerms = $form->getData()["search"];
            $results = $repository->searchByTags($searchTerms);
        }

        return $this->render('gif/search.html.twig', [
            'form' => $form->createView(),
            'searchTerms' => $searchTerms,
            'gifs' => $results,
        ]);
    }
}