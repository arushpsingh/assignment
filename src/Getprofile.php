<?php

namespace Drupal\transcode_profile;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Getprofile
 */
class Getprofile
{
    /**
     * Drupal\Core\Config\ConfigFactoryInterface definition
     * 
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * Construct a new Getprofile object
     */
    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->configFactory = $config_factory;
    }

    public function getProfileValue()
    {
    }

    public function getCity()
    {
        $worldapi = $this->configFactory->get('transcode_profile.worldtimeapi');
        return $worldapi->get('city');
    }

    public function getCountry()
    {
        $worldapi = $this->configFactory->get('transcode_profile.worldtimeapi');
        return $worldapi->get('country');
    }

    public function getTimezone()
    {
        $worldapi = $this->configFactory->get('transcode_profile.worldtimeapi');
        return $worldapi->get('timezone');
    }
}
