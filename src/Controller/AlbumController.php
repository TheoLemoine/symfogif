<?php


namespace App\Controller;


use App\Entity\Album;
use App\Form\AlbumForm;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{

    /**
     * @Route("/", name="app_album_list")
     * @param AlbumRepository $albumRepository
     * @return Response
     */
    public function index(AlbumRepository $albumRepository)
    {
        $albums = $albumRepository->findBy([], ['id' => 'DESC'], 20);

        return $this->render('album/list.html.twig', [
            'albums' => $albums,
        ]);
    }

    /**
     * @Route("/album/{id<\d+>}", name="app_album_show")
     * @param Album $album
     * @param AlbumRepository $repository
     * @return Response
     */
    public function show(Album $album)
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/album/add", name="app_album_add")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(AlbumForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $album->setAuthor($this->getUser());
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('app_album_list');
        }

        return $this->render('album/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/album/{id}/edit", name="app_album_update")
     * @param Album $album
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function update(Album $album, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(AlbumForm::class, $album);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_album_list');
        }

        return $this->render('album/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}