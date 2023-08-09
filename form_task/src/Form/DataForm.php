<?php
/**
 * @file
 * Contains \Drupal\student_registration\Form\RegistrationForm.
 */
namespace Drupal\form_task\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataForm extends FormBase {

  protected $messenger;
  protected $database;

public function __construct(MessengerInterface $messenger, Connection $database) {
  $this->messenger = $messenger;
  $this->database = $database;
}

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

  public function buildForm(array $form, FormStateInterface $form_state)
  {
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
