<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 4/5/17
 * Time: 3:10 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    /**
     * @Route("/action")
     */
    public function numberAction(){
        $number = mt_rand(0, 100);

        $notes = [
            'How are you ?',
            'I am fine.',
            'My name is',
            'Lalit Kumar'
        ];

        return $this->render('design/number.html.twig', array(
            'number' => $number,
            'notes' => $notes,
        ));
    }
}