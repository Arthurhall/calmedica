<?php

namespace App\Controller;

use App\Form\AcknowledgementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcknowledgementController extends AbstractController
{
    /**
     * @Route("/acknowledgement", name="acknowledgement")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(AcknowledgementType::class, null, [
            'method' => 'GET',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // ...
            return new Response('probleme', Response::HTTP_OK, ['content-type' => 'text/plain']);
        }

        return new Response('validation', Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}
