<?php

namespace Drupal\state_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Returns state values form.
 */
class StateForm extends FormBase {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * Sets the form id.
   */
  public function getFormId() {
    return 'state_form';
  }

  /**
   * Constructor for the service.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger service.
   */
  public function __construct(LoggerChannelFactoryInterface $logger_factory) {
    $this->logger = $logger_factory->get('state_form');
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')
    );
  }

  /**
   * Build form function.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'state_form/js_lib';
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
    ];
    $form['checkbox'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Last Name'),
      '#attributes' => ['id' => 'checkbox'],
    ];
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#attributes' => ['id' => 'lastname'],
      // '#states' => [
      //   'invisible' => [
      //     ':input[name="checkbox"]' => ['checked' =>false],
      //   ],
      // ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * Submit form function.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $firstname = $form_state->getValue('firstname');
    $lastname = $form_state->getValue('lastname');

    // Alternatives of notice: warning, error, info.
    $this->logger->notice('Form Submitted. First Name: @first_name, Last Name: @last_name', [
      '@first_name' => $firstname,
      '@last_name' => $lastname,
    ]);

  }

}
