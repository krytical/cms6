<?php

namespace ExampleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        return new Response(
            '<html><body> lucky number </body></html>'
        );
    }
}
