<?php

namespace Drupal\access_task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Access Task Module settings for this site.
 */
class SettingsForm extends ConfigFormBase {


  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'access_task_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['access_task.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Load available roles.
    $roles = array_map(
      function ($role) {
        return $role->label();
      },
      user_roles()
    );

    // Load available content types.
    $content_type_manager = $this->entityTypeManager->getStorage('node_type');
    $content_types = array_map(
      function ($type) {
        return $type->label();
      },
      $content_type_manager->loadMultiple()
    );

    $config = $this->config('access_task.settings');

    $form['roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Roles'),
      '#options' => $roles,
      '#default_value' => $config->get('roles'),
    ];

    $form['content_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content Types'),
      '#options' => $content_types,
      '#default_value' => $config->get('content_types'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('access_task.settings')
      ->set('roles', array_filter($form_state->getValue('roles')))
      ->set('content_types', array_filter($form_state->getValue('content_types')))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
