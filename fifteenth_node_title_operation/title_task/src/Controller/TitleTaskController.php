<?php

namespace Drupal\title_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for Title Controller Task routes.
 */
class TitleTaskController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(Node $node) {
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
