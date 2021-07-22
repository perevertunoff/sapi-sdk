<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AccessKey;
use App\Service\Profile;
use App\Service\Method;

/**
 * @Route(methods={"GET", "POST"})
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->json(['error' => 'Incorrect request']);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(Profile $profile)
    {
        // dump($profile);
        return $this->json(['result' => 'Test']);
    }

    /**
     * @Route("/{access_key}/{method_name}", name="method")
     */
    public function method($method_name, AccessKey $accessKey, Method $method)
    {
        if ($accessKey->isNotAllowed()) {
            return $this->json(['error' => 'Access not allowed']);
        }

        if (!method_exists($method, $method_name)) {
            return $this->json(['error' => 'Method not found']);
        }

        return $this->json($method->$method_name());
    }
}
