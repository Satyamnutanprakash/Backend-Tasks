<?php

namespace Drupal\form_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns responses for Custom Form Task routes.
 */
class FormTaskController extends ControllerBase {
  protected $database;

public function __construct(Connection $database) {
  $this->database = $database;
}

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
      '#theme' => 'custom_template',
      '#rows' => $rows,
    ];

    return $build;
  }
}
