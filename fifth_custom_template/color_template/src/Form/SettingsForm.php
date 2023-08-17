<?php

namespace Drupal\color_template\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Color Template Task Module for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'color_template_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['color_template.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->config('color_template.settings')->get('title'),
    ];

    $text_format = 'basic_html';
    if ($this->config('color_template.settings')->get('paragraph')['format']) {
      $text_format = $this->config('template_task.settings')->get('paragraph')['format'];
    }

    $form['paragraph'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Paragraph'),
      '#format' => $text_format,
      '#default_value' => $this->config('color_template.settings')->get('paragraph')['value'],
    ];

    $form['color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Color Code'),
      '#default_value' => $this->config('color_template.settings')->get('color'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('color_template.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('paragraph', $form_state->getValue('paragraph'))
      ->set('color', $form_state->getValue('color'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
