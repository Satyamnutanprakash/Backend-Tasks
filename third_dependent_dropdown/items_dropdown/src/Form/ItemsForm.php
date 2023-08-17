<?php

namespace Drupal\items_dropdown\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Items Dropdown Form.
 */
class ItemsForm extends FormBase {

  /**
   * Database connection object.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a DropdownForm object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection object.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'items_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $opt = static::getItems();
    $item = $form_state->getValue('electronic_item');

    $modal = $form_state->getValue('modal');

    $form['electronic_item'] = [
      '#type' => 'select',
      '#title' => 'Electronic Item',
      '#options' => $opt,
      '#empty_option' => '-Select-',
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::dropdownCallback',
        'wrapper' => 'modal-wrapper',
        'event' => 'change',
      ],
    ];

    $form['modal'] = [
      '#type' => 'select',
      '#title' => 'Modal',
      '#options' => static::getModals($item),
      '#empty_option' => '-Select-',
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::dropdownCallback',
        'wrapper' => 'color-wrapper',
        'event' => 'change',
      ],
      '#prefix' => '<div id = "modal-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['color'] = [
      '#type' => 'select',
      '#title' => 'Color',
      '#options' => static::getColors($modal),
      '#empty_option' => '-Select-',
      '#required' => TRUE,
      '#prefix' => '<div id = "color-wrapper">',
      '#suffix' => '</div>',
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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger != 'submit') {
      $form_state->setRebuild();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function dropdownCallback(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'electronic_item') {
      return $form['modal'];
    }
    elseif ($triggering_element_name === 'modal') {
      return $form['color'];
    }
  }

  /**
   * Function to get items.
   */
  public function getItems() {
    $query = $this->database->select('electronic_item', 'e');
    $query->fields('e', ['item_id', 'item_name']);
    $result = $query->execute()->fetchAll();
    $options = [];
    foreach ($result as $row) {
      $options[$row->item_id] = $row->item_name;
    }
    return $options;
  }

  /**
   * Function to get modals.
   */
  public function getModals($item) {
    $query = $this->database->select('modal', 'm');
    $query->fields('m', ['modal_id', 'modal_name']);
    $query->condition('m.item_id', $item);
    $result = $query->execute()->fetchAll();
    $options = [];
    foreach ($result as $row) {
      $options[$row->modal_id] = $row->modal_name;
    }
    return $options;
  }

  /**
   * Function to get colors.
   */
  public function getColors($modal) {
    $query = $this->database->select('color', 'c');
    $query->fields('c', ['color_id', 'color_name']);
    $query->condition('c.modal_id', $modal);
    $result = $query->execute()->fetchAll();
    $options = [];
    foreach ($result as $row) {
      $options[$row->color_id] = $row->color_name;
    }
    return $options;
  }

}
