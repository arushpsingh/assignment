<?php

namespace Drupal\transcode_profile\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AdminConfigurationForm extends FormBase
{
    public function getEditableConfigNames()
    {
        return [
            'transcode_profile.testing',
        ];
    }
    //Define Form Id
    public function getFormId()
    {
        return "admin_settings_form";
    }

    //Form building
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('transcode_profile.testing');
        $form['profile_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Profile Name'),
            '#description' => $this->t('Profile Name'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('profile_name'),
        ];
        $form['enable_transcoding'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Enable transcoding'),
            '#description' => $this->t('Enable transcoding'),
            '#default_value' => $config->get('enable_transcoding'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);

        $this->config('transcode_profile.testing')
            ->set('profile_name', $form_state->getValue('profile_name'))
            ->set('enable_transcoding', $form_state->getValue('enable_transcoding'))
            ->save();
        \Drupal::cache('bootstrap')->invalidateAll();
    }
}
