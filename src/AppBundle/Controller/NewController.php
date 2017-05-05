<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 5/5/17
 * Time: 10:53 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
// ...

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class NewController extends Controller
{
// ...
    /**
     * @Route("/insert")
     */
    public function createAction()
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        $em = $this->getDoctrine()->getManager();

// tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

// actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

    // ...
    /**
     * @Route("/show", name="Homepage")
     */
    public function showAction()
    {
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        // ... do something, like pass the $product object into a template
        return $this->render('design/view.html.twig', array(
            'product' => $product,

        ));
    }

    // ...
    /**
     * @Route("/update/{productId}", name="update")
     */
    public function updateAction( Request $request, $productId)
    {
        // create a task and give it some dummy data for this example
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($productId);

        $productObj = new Product();
        $productObj->setName($product->getName('productName'));
        $productObj->setPrice($product->getPrice('productPrice'));
        $productObj->setDescription($product->getDescription('productDescription'));

        $form = $this->createFormBuilder($productObj)
            ->add('Name', TextType::class)
            ->add('Price', TextType::class)
            ->add('Description', TextareaType::class)

            ->add('save', SubmitType::class, array('label' => 'Update product'))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //$product = $em->getRepository('AppBundle:Product')->find($productId);

            $product->setName($form->get('Name')->getData());
            $product->setPrice($form->get('Price')->getData());
            $product->setDescription($form->get('Description')->getData());

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('Homepage');

        }

        return $this->render('design/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // ...
    /**
     * @Route("/delete/{productId}", name="deleteAction")
     */
    public function  deleteAction($productId){
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AppBundle:Product')->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id' .$productId
            );
        }

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('Homepage');
    }

}