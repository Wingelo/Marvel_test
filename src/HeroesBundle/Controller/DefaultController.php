<?php

namespace HeroesBundle\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Chadicus\Marvel\Api\Request;
use HeroesBundle\Entity\FavoritesHeroes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Chadicus\Marvel\Api\Client;
use Chadicus\Marvel\Api\Entities\Character;


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
        $cachedMarvel = $this->get('cache.app')->getItem('character');

        $em = $this->getDoctrine()->getManager();
        $listFavoritesMarvel = $em->getRepository('HeroesBundle:FavoritesHeroes')->findAll();

        if(!$cachedMarvel->isHit()){
            $character = $client->characters();
            $cachedMarvel->set($character);
            $this->get('cache.app')->save($cachedMarvel);
        } else {
            $character = $cachedMarvel->get();
        }




        return $this->render('HeroesBundle:Default:index.html.twig', array(
            'character' => $character,
            'favoris' => $listFavoritesMarvel,
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

    /**
     * @Route ("/favorites/{id}")
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function favoritesAction($id){

        $em = $this->getDoctrine()->getManager();
        $listFavoritesMarvel = $em->getRepository('HeroesBundle:FavoritesHeroes')->findAll();
        $countHeroes = count($listFavoritesMarvel);

        $publicApiKey = $this->getParameter('public_key_marvel');
        $privateApiKey = $this->getParameter('private_key_marvel');

        if($countHeroes == 5) {
            $this->addFlash(
                'notice',
                'Vous avez déjà 5 héros dans vos favoris'
            );
            return $this->redirectToRoute('heroes_default_index');
        }
        else
        {
            $client = new Client($privateApiKey, $publicApiKey);

            $response = $client->get('characters', intval($id));

            $wrapper = $response->getDataWrapper();
            $character = $wrapper->getData()->getResults()[0];

            $heroes = new FavoritesHeroes();

            $heroes->setCode($id);
            $heroes->setName($character->getName());
            $heroes->setImage($character->getThumbnail()->getPath() .'.'. $character->getThumbnail()->getExtension());

            $em->persist($heroes);
            $em->flush();
            $this->addFlash(
                'notice',
                'Ton héros a été mis en favoris !!'
            );

            return $this->redirectToRoute('heroes_default_index');
        }


    }

    /**
     * @Route("/favorites")
     */
    public function favoritesListAction(){
        $em = $this->getDoctrine()->getManager();
        $listFavoritesMarvel = $em->getRepository('HeroesBundle:FavoritesHeroes')->findAll();

        return $this->render('@Heroes/Default/list_favorites.html.twig', array(
            'favorites' => $listFavoritesMarvel,
        ));
    }

}
