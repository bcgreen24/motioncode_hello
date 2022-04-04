<?php

namespace Drupal\hello\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\hello\Services\HelloSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the salutation message.
 */

class HelloController extends ControllerBase
{
    /**
     * @var \Drupal\hello\HelloSalutation
     */

    protected $salutation;

    /**
     * HelloController constructor.
     * 
     * @param \Drupal\hello\HelloSalutation $salutation
     */

    public function __construct(HelloSalutation $salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * {@inheritdoc}
     */

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('hello.salutation')
        );
    }

    /**
     * Hello World.
     * 
     * @return array
     *  Our message.
     * 
     */

    public function helloWorld()
    {
       return $this->salutation->getSalutation();
        
    }
}