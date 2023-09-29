<?php

namespace Drupal\transcode_profile\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Cache\CacheTagsInvalidatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WorldTimeApi
 */
class WorldTimeApi extends ConfigFormBase
{
    protected $cacheTagsInvalidator;

    public function __construct(CacheTagsInvalidatorInterface $cache_tags_invalidator)
    {
        $this->cacheTagsInvalidator = $cache_tags_invalidator;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('cache_tags.invalidator')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableConfigNames()
    {
        return [
            'transcode_profile.worldTimeApi'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'world_time_api';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('transcode_profile.worldTimeApi');
        $form['country'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Country'),
            '#description' => $this->t('Country'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('country'),
        ];
        $form['city'] = [
            '#type' => 'textfield',
            '#title' => $this->t('City'),
            '#description' => $this->t('City'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('city'),
        ];
        $form['timezone'] = [
            '#type' => 'select',
            '#title' => $this->t('Timezone'),
            '#description' => $this->t('Timezone'),
            '#options' => [
                'America/Chicago' => $this->t('America/Chicago'),
                'America/New_York' => $this->t('America/New_York'),
                'Asia/Tokyo' => $this->t('Asia/Tokyo'),
                'Asia/Dubai' => $this->t('Asia/Dubai'),
                'Asia/Kolkata' => $this->t('Asia/Kolkata'),
                'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
                'Europe/Oslo' => $this->t('Europe/Oslo'),
                'Europe/London' => $this->t('Europe/London'),
            ],
            '#size' => 8,
            '#multiple' => TRUE,
            '#default_value' => $config->get('timezone'),
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);

        $this->config('transcode_profile.worldTimeApi')
            ->set('country', $form_state->getValue('country'))
            ->set('city', $form_state->getValue('city'))
            ->set('timezone', $form_state->getValue('timezone'))
            ->save();
        //flush cache
        $this->cacheTagsInvalidator->invalidateTags(['time_zone_unique_tag']);
        //Drupal::cache('render)
        \Drupal::service('cache.render')->invalidateAll();
    }
}
