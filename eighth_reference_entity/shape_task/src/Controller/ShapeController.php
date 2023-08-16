<?php

namespace Drupal\shape_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defines a controller that outputs node values.
 */
class ShapeController extends ControllerBase {

  /**
   * Displays the node values.
   */
  public function displayNode() {
    // Load the node with ID '1'.
    $id = 1;
    $node = Node::load($id);

    if ($node) {
      $node_title = $node->getTitle();
      $term_reference = $node->get('field_colors')->referencedEntities()[0];
      $color = $term_reference->getName();

      $user_reference = $term_reference->get('field_users')->referencedEntities()[0];
      $user = $user_reference->getDisplayName();

      $output = '<h2>' . $node_title . ' ' . $color . ' ' . $user . '</h2>';

      $build = [
        '#type' => 'markup',
        '#markup' => $output,
      ];
      return $build;
    }

    return new Response($output);
  }

}
