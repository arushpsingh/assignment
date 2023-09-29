<?php

namespace Drupal\transcode_profile\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;



/**
 * Provides a 'GetProfileBlock' block.
 *
 * @Block(
 *  id = "get_profile_block",
 *  admin_label = @Translation("Get Profile Block"),
 * )
 */

class GetProfileBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * Drupal\transcode_profile\Gteprofile definition
     *
     * @var \Drupal\transcode_profile\Getprofile
     */
    protected $getprofile;

    protected $configFactory;

    /**
     * {@inheritdoc}
     */
    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
        // $instance = new static($configuration, $plugin_id, $plugin_definition);
        // $instance = $container->get('config.factory');
        // return $instance;
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('config.factory')
        );
    }

    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        ConfigFactoryInterface $configFactory
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->configFactory = $configFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $entity_load = \Drupal::config('transcode_profile.worldTimeApi');
        // $config = $this->configFactory->get('transcode_profile.worldTimeApi');
        // $country = $config->get('country');
        // $city = $config->get('city');
        // $timezone = $config->get('timezone');

        // $build = [
        //     '#markup' => $this->t('Country: @country, City: @city, Timezone: @timezone', [
        //         '@country' => $country,
        //         '@city' => $city,
        //         '@timezone' => $timezone,
        //     ]),
        // ];

        $build = [];

        $build['#theme'] = 'testing';
        $build['#country'] = $entity_load->get('country');
        $build['#city'] = $entity_load->get('city');
        $build['#attached']['drupalSettings']['timezone'] = $entity_load->get('timezone');
        $build['#attached']['library'] = 'transcode_profile/js-example';
        $build['#cache'] = array('time_zone_unique_tag');

        // $build = ['#markup' => $entity_load->get('city')];
        return $build;
    }

    public function getCacheMaxAge()
    {
        return -1;
        //60 means 60 seconds
        //PERMANENT(-1) means only cleared through cache tags
    }
}
