<?php
/**
 * Created by PhpStorm.
 * User: lalit
 * Date: 5/5/17
 * Time: 5:14 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class AjaxController extends Controller
{
    /**
     * @return Response
     * @Route ("/suggest", name="hint")
     */
    public function suggestAction(){

        // Array with names
        $a[] = "Anna";
        $a[] = "Brittany";
        $a[] = "Cinderella";
        $a[] = "Diana";
        $a[] = "Eva";
        $a[] = "Fiona";
        $a[] = "Gunda";
        $a[] = "Hege";
        $a[] = "Inga";
        $a[] = "Johanna";
        $a[] = "Kitty";
        $a[] = "Linda";
        $a[] = "Nina";
        $a[] = "Ophelia";
        $a[] = "Petunia";
        $a[] = "Amanda";
        $a[] = "Raquel";
        $a[] = "Cindy";
        $a[] = "Doris";
        $a[] = "Eve";
        $a[] = "Evita";
        $a[] = "Sunniva";
        $a[] = "Tove";
        $a[] = "Unni";
        $a[] = "Violet";
        $a[] = "Liza";
        $a[] = "Elizabeth";
        $a[] = "Ellen";
        $a[] = "Wenche";
        $a[] = "Vicky";

        $q = $_REQUEST["q"];

        $hint = "";

        if ($q !== ""){
            $q = strtolower($q);
            $len  = strlen($q);

            foreach ($a as $name){
                if (stristr($q, substr($name, 0, $len))){
                    if ($hint === ""){
                        $hint = $name;
                    }
                    else{
                        $hint .= ", $name";
                    }
                }
            }
        }
        return new Response($hint);
    }
}