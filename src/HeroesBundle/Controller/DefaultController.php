<?php

namespace HeroesBundle\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Chadicus\Marvel\Api\Client;
use Chadicus\Marvel\Api\Entities\Character;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $publicApiKey = $this->getParameter('public_key_marvel');
        $privateApiKey = $this->getParameter('private_key_marvel');

        $client = new Client($privateApiKey, $publicApiKey);

        $character = $client->characters();

        return $this->render('HeroesBundle:Default:index.html.twig', array(
            'character' => $character
        ));
    }

    /**
     * @Route("/description/{id}")
     * @Method({"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function descriptionAction($id)
    {
        $publicApiKey = $this->getParameter('public_key_marvel');
        $privateApiKey = $this->getParameter('private_key_marvel');

        $client = new Client($privateApiKey, $publicApiKey);

        $response = $client->get('characters', intval($id));
        $responsecomics = $client->search('comics', ['characters' => intval($id)]);

        $wrapper = $response->getDataWrapper();
        $wrappercomics = $responsecomics->getDataWrapper();

        $comics = $wrappercomics->getData()->getResults();
        $character = $wrapper->getData()->getResults()[0];
        return $this->render('HeroesBundle:Default:description_marvel.html.twig', array(
            'character' => $character,
            'comics' => $comics
        ));

    }
}
