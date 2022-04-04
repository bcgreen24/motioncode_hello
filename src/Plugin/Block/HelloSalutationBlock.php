<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hello\Services\HelloSalutation;
use Drupal\Core\Form\FormStateInterface;

/**
 * Hello Salutation block.
 * 
 * @Block(
 * id= "hello_salutation_block",
 * admin_label = @Translation("Hello salutation"),
 * )
 */

class HelloSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * The salutation service.
     * 
     * @var \Drupal\hello\HelloSalutation
     */

    protected $salutation;

    /** 
     * Constructs a HelloSalutationBlock.
     */

    public function __construct(array $configuration, $plugin_id, $plugin_definition, HelloSalutation $salutation)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->salutation = $salutation;
    }

    /**
     * {@inheritdoc}
     */

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('hello.salutation')
        );
    }

    /**
     * {@inheritdoc}
     */

    public function build()
    {
        $config = $this->getConfiguration();
        if ($config['enabled'] == 1){
        return $this->salutation->getSalutation();
        }
    }

    /**
     * {@inheritdoc}
     */

     public function defaultConfiguration()
     {
         return [
             'enabled' => 1,
         ];
     }

    /**
     * {@inheritdoc}
     */

    public function blockForm($form, FormStateInterface $form_state)
    {
        $config = $this->getConfiguration();
        $form['enabled'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Enabled'),
            '#decription' => $this->t('Check this box to enable this feature.'),
            '#default_value' => $config['enabled'],
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['enabled'] = $form_state->getValue('enabled');
    }
}
