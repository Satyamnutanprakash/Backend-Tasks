<?php

namespace Drupal\shape_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defines a controller that outputs node values.
 */
class ShapeEntityController extends ControllerBase {
  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * CustomNodeInfoController constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Displays the node values.
   */
  public function displayNode() {
    // Load the node with ID '1'.
    $id = 1;
    $node = $this->entityTypeManager->getStorage('node')->load($id);

    if ($node) {
      $node_title = $node->getTitle();
      $term_reference = $node->get('field_colors')->entity;
      $term = $term_reference->getName();
      $user_reference = $term_reference->get('field_users')->entity->getDisplayName();

      $output = '<h2>' . $node_title . ' ' . $term . ' ' . $user_reference . '</h2>';
      $build = [
        '#type' => 'markup',
        '#markup' => $output,
      ];
      return $build;
    }

    return new Response($output);
  }

}
