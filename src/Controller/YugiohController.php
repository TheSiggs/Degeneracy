<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YugiohController extends AbstractController {
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }
    /**
     * @Route("/yugioh", name="yugioh")
     */
    public function index(): Response {
        $response = $this->client->request('GET', 'https://db.ygoprodeck.com/api/v7/cardinfo.php?type=Normal%20Monster');
        $content = $response->toArray();
        $cards = $content['data'];
        return $this->render('yugioh/index.html.twig', compact('cards'));
    }
}