<?php

namespace Drupal\form_task\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns information form.
 */
class DataForm extends FormBase {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor for the service.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('messenger'),
    $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'data_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
    ];
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => 'Last Name',
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
      '#required' => TRUE,
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => 'Phone Number',
    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
        'male' => 'Male',
        'female' => 'Female',
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(&$form, FormStateInterface $form_state) {
    $this->messenger->addMessage("Your Data Saved Successfully");
    $this->database->insert("form_data")->fields(
      [
        'firstname' => $form_state->getValue('firstname'),
        'lastname' => $form_state->getValue('lastname'),
        'email' => $form_state->getValue('email'),
        'phone' => $form_state->getValue('phone'),
        'gender' => $form_state->getValue('gender'),
      ]
    )->execute();
  }

}
