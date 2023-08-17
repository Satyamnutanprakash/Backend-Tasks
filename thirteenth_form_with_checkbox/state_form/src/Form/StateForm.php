<?php

namespace Drupal\state_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Logger\LoggerChannel;
use Drupal\Core\Logger\LoggerChannelFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;


class StateForm extends FormBase {


  protected $logger;

  public function getFormId() {
    return 'state_form';
  }

  public function __construct(LoggerChannelFactoryInterface $logger_factory)
  {
    $this->logger = $logger_factory->get('state_form');
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('logger.factory')
    );
  }

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

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $firstname = $form_state->getValue('firstname');
    $lastname = $form_state->getValue('lastname');

    // $this->logger->info('Form Submitted. First Name: @first_name, Last Name: @last_name', [
    //   '@first_name' => $firstname,
    //   '@last_name' => $lastname,
    // ]);
    // $this->logger->error('Form Submitted. First Name: @first_name, Last Name: @last_name', [
    //   '@first_name' => $firstname,
    //   '@last_name' => $lastname,
    // ]);
    // $this->logger->warning('Form Submitted. First Name: @first_name, Last Name: @last_name', [
    //   '@first_name' => $firstname,
    //   '@last_name' => $lastname,
    // ]);
    $this->logger->notice('Form Submitted. First Name: @first_name, Last Name: @last_name', [
      '@first_name' => $firstname,
      '@last_name' => $lastname,
    ]);
    // $this->logger('state_form')->error($message);

  }
}
