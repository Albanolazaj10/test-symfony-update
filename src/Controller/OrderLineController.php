<?php

namespace App\Controller;

use App\Entity\OrderLine;
use App\Form\OrderLineType;
use App\Repository\OrderLineRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/line", name="order_line.")
 */
class OrderLineController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(OrderLineRepository $ol): Response
    {
        $orderLined = $ol->findAll();

        return $this->render('order_line/index.html.twig', [
            'orderLined' => $orderLined,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $orderLine = new OrderLine();

        //Form
        $form = $this->createForm(OrderLineType::class, $orderLine);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderLine);
            $em->flush();

            return $this->redirect($this->generateUrl('order_line.edit'));
        }
     
        //Response
        return $this->render('order_line/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

    
//--------------------------------------UPDATE------------------------------------------
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id, Request $request)
    {
        $orderLine = new OrderLine();
        $orderLine = $this->getDoctrine()->getRepository(OrderLine::class)->find($id);

        $form = $this->createFormBuilder($orderLine)
            ->add('product')
            ->add('count')
            ->add('totalPrice', MoneyType::class, ['divisor' => 100])
            ->add('discount', MoneyType::class, ['divisor' => 100])
            ->add('orderL')
            ->add('Update', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($orderLine);
            $em->flush();

            return $this->redirect($this->generateUrl('order_line.edit'));
        }

        
        return $this->render('order_line/update.html.twig', [
            'createForm' => $form->createView()
        ]);
    }
//--------------------------------------END UPDATE-----------------------------------------------
   
   
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, OrderLineRepository $ol)
    {
        $orderLine = $this->getDoctrine()->getRepository(OrderLine::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($orderLine);
        $em->flush();

        //message
        $this->addFlash('success', 'OrderLine was removed succesfully!');

        return $this->redirect($this->generateUrl('order_line.edit'));
    }
    
    /**
     * @Route("/show_line/{id}", name="show-line")
     */
    public function show(OrderLine $ordereLine)
    {
        return $this->render('order_line/show.html.twig', [
            'ordereLine' => $ordereLine
        ]);
    }

}
