<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Video;
use App\Utils\CategoryTreeFrontPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/video_list/category/{categoryName},{id}/{page}",
     *  defaults={"page": "1"},
     *  name="videoList")
     */
    public function videoList($id, $page, CategoryTreeFrontPage $categories)
    {
        $categories->getCategoryListAndParent($id);
        $ids = $categories->getChildIds($id);
        array_push($ids, $id);
        $videos = $this->getDoctrine()->getRepository(Video::class)->findByChildIds($ids, $page);
        return $this->render('front/video_list.html.twig', [
            'controller_name' => 'FrontController',
            'subcategories' => $categories,
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/video_details", name="videoDetails")
     */
    public function videoDetails()
    {
        return $this->render('front/video_details.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/search_results", methods={"POST"}, name="searchResults")
     */
    public function searchResults()
    {
        return $this->render('front/search_results.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing()
    {
        return $this->render('front/pricing.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('front/register.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('front/login.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment()
    {
        return $this->render('front/payment.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    public function mainCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findBy(['parent' => null], ['name'=>'ASC']);
        return $this->render('front/_main_categories.html.twig', [
            'categories' => $categories
        ]);
    }
}
