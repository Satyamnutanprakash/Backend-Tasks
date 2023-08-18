<?php

namespace Drupal\node_view\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Function.
 */
class NodeLinkController extends ControllerBase {

  /**
   * Function.
   */
  public function getNode(Node $node) {
    if (!empty($node)) {
      $title = $node->getTitle();
      return [
        '#markup' => $title,
      ];
    }
    else {
      throw new NotFoundHttpException();
    }
  }

}
