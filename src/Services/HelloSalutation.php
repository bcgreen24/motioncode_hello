<?php

namespace Drupal\hello\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prepares the greeting for the world.
 * 
 */

class HelloSalutation
{
    use StringTranslationTrait;

    /**
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */

    protected $configFactory;

    /**
     * HellSalutation constructor.
     * 
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     */

    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->configFactory = $config_factory;
    }

    /**
     * Returns the greeting.
     */

    public function getSalutation()
    {
        $render = [
            '#theme' => 'hello_salutation',
            '#cache' => [
                '#max-age' => 0
            ],
            '#salutation' => NULL,
            '#attached' => [
                'library' => [
                    'hello/hello-library'
                ]
            ]
        ];

        $config = $this->configFactory->get('hello.custom_salutation');
        $salutation = $config->get('salutation');
        if ($salutation !== "" && $salutation) {
            $render['#salutation'] = $salutation;
            return $render;
        }

        $time = new \DateTime();
        if ((int)$time->format('G') >= 00 && (int)$time->format('G') < 12) {
            $render['#salutation'] = $this->t('Good morning, world!');
            return $render;
        }
        if ((int)$time->format('G') >= 12 && (int)$time->format('G') < 18) {
            $render['#salutation'] = $this->t('Good afternoon, world!');
            return $render;
        }
        if ((int)$time->format('G') >= 18) {
            $render['#salutation'] = $this->t('Good evening, world!');
            return $render;
        }
    }
}
