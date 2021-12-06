<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/order", name="order.")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(OrderRepository $or): Response
    {
        $ordere = $or->findAll();

        return $this->render('order/index.html.twig', [
            'ordere' => $ordere
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $order = new Order();

        //Form
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->redirect($this->generateUrl('order.edit'));
        }

        //Response
        return $this->render('order/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

//--------------------------------------UPDATE------------------------------------------
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id, Request $request)
    {
        $order = new Order();
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);

        $form = $this->createFormBuilder($order)
            ->add('orderCode')
            ->add('orderDate')
            ->add('costumerName')
            ->add('description')
            ->add('totalAmount', MoneyType::class, ['divisor' => 100])
            ->add('orderLines')
            ->add('Update', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->redirect($this->generateUrl('order.edit'));
        }

        return $this->render('order/update.html.twig', [
            'createForm' => $form->createView()
        ]);
    }
//--------------------------------------END UPDATE--------------------------------------  
    

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, OrderRepository $or)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $or->find($id);
        $em->remove($order);
        $em->flush();
        
        //message
        $this->addFlash('success', 'Order was removed succesfully!');

        return $this->redirect($this->generateUrl('order.edit'));
    }

    /**
     * @Route("/show_order/{id}", name="show-order")
     */
    public function show(Order $order)
    {
        return $this->render('order/show.html.twig', [
            'order' => $order
        ]);
    }

}