<?php

namespace AppBundle\Controller;

use \AppBundle\Model\Config;
use \PommProject\Foundation\Session\Session;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\Templating\EngineInterface;
use \Symfony\Component\PropertyInfo\PropertyInfoExtractor;

class IndexController
{
    private $pomm;
    private $templating;
    private $property;

    public function __construct(
        EngineInterface $templating,
        Session $pomm,
        PropertyInfoExtractor $property
    ) {
        $this->pomm = $pomm;
        $this->templating = $templating;
        $this->property = $property;
    }

    public function indexAction()
    {
        $result = $this->pomm->getQueryManager()
            ->query('select 1');

        return new Response(
            $this->templating->render(
                'AppBundle:Front:index.html.twig'
            )
        );
    }

    public function getAction(Config $config)
    {
        return new Response(
            $this->templating->render(
                'AppBundle:Front:get.html.twig',
                compact('config')
            )
        );
    }

    public function failAction()
    {
        $this->pomm->getQueryManager()
            ->query('select 1 from');
    }

    public function propertyAction()
    {
        $info = $this->property->getTypes(Config::class, 'name');

        return new Response(
            $this->templating->render(
                'AppBundle:Front:property.html.twig',
                compact('info')
            )
        );
    }
}
