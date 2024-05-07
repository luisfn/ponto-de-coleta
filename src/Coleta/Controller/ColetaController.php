<?php

declare(strict_types=1);

namespace Coleta\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ColetaController extends AbstractController
{
public function index(): Response
{
        return new Response('Hello World!');
    }
}