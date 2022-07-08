<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PogmonController extends AbstractController {
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }
    /**
     * @Route("/pogmon", name="Pogmon")
     */
    public function index(): Response {
        $emotes = [];
        $channels = ['40934651', '44445592', '37455669', '71092938'];
        $blacklisted = [
            '249060', '325413', '513200', '517775', '139407', '589865', '229486', '332474', '391396', '381875',
            '241298', '644536', '229486', '357348', '405963', '85645', '410522', '229486'
        ];
        foreach ($channels as $channel) {
            $response = $this->client->request('GET', 'https://api.betterttv.net/3/cached/frankerfacez/users/twitch/'.$channel);
            $content = $response->toArray();
            $emotes = array_merge($emotes, $content);
        }
        $emotes = array_filter($emotes, function ($emote) use ($blacklisted) {
            return !in_array($emote['id'], $blacklisted);
        });
        $choice = array_rand($emotes, 1);
        $emote = $emotes[$choice];

        return $this->render('pogmon/index.html.twig', compact('emote'));
    }
}