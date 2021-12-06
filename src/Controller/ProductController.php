<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="edit")
     */
    public function index(ProductRepository $pr): Response
    {
        $producte = $pr->findAll();

        return $this->render('product/index.html.twig', [
            'producte' => $producte,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request) 
    {
        $product = new Product();

        //Form
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('product.edit'));
        }

        //Response
        return $this->render('product/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

//--------------------------------------UPDATE------------------------------------------
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id, Request $request)
    {
        $product = new Product();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('code')
            ->add('price', MoneyType::class, ['divisor' => 100])
            ->add('stock', MoneyType::class, ['divisor' => 100])
            ->add('description')
            ->add('Update', SubmitType::class)
            ->getForm();
    
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                return $this->redirect($this->generateUrl('product.edit'));
            }

            return $this->render('product/update.html.twig', [
                'createForm' => $form->createView()
            ]);
    }
//--------------------------------------END UPDATE--------------------------------------  


    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, ProductRepository $pr)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $pr->find($id);
        $em->remove($product);
        $em->flush();

        //message
        $this->addFlash('success', 'Product was removed succesfully!');

        return $this->redirect($this->generateUrl('product.edit'));
    }

    /**
     * @Route("/show_product/{id}", name="show-product")
     */ 
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);       
    }

}

    