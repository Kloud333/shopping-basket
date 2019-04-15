<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Test controller.
 */
class APITestController extends AbstractFOSRestController
{
    /**
     * Just test
     * @Rest\Post("/test")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $body = $request->getContent();

        return new Response($body);
    }
}
