<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function menu(OrderRepository $or): Response
    {
        $ordere = $or->findAll();

        return $this->render('menu/index.html.twig', [
            'ordere' => $ordere
        ]);
    }
}
