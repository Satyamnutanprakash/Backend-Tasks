<?php

namespace Drupal\form_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Custom Form Task routes.
 */
class FormTaskController extends ControllerBase {
  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor for the database service.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('database')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    $query = $this->database->select('form_data', 'fd')
      ->fields('fd', ['id', 'firstname', 'lastname', 'email', 'phone', 'gender'])
      ->execute();

    $rows = [];

    $header = [
      'id' => t('ID'),
      'firstname' => t('First Name'),
      'lastname' => t('Last Name'),
      'email' => t('Email'),
      'phone' => t('Phone'),
      'gender' => t('Gender'),
    ];

    foreach ($query as $row) {
      $rows[] = [
        'id' => $row->id,
        'firstname' => $row->firstname,
        'lastname' => $row->lastname,
        'email' => $row->email,
        'phone' => $row->phone,
        'gender' => $row->gender,
      ];
    }

    $build = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

}
