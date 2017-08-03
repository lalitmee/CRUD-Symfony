<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    /**
     * @Route("/new", name="newItem")
     */
    public function newAction(Request $request){
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('Name', TextType::class)
            ->add('Price', TextType::class)
            ->add('Description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Add Product'))
            ->getform();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $em = $this->getDoctrine()->getManager();
            $em->persist($product);
             $em->flush();


            return $this->redirectToRoute('Homepage');
        }

        return $this->render('design/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
