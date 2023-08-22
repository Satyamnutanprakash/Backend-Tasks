<?php

namespace Drupal\cache_sn\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Cache\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns responses for Cache Task routes.
 */
class CacheSnController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(Node $node) {

    $nid = $node->id();
    $cid = 'marklove:' . $nid;

    // Look for the item in cache so we don't have to do the work if we don't need to.
    if ($item = \Drupal::cache()->get($cid)) {
      return $item->data;
    }

    // Build up the markdown array we're going to use later.
    $node = Node::load($nid);
    $title = $node->get('title')->value;
    $marklove = [
      '#title' => $title,
    ];

    // Set the cache so we don't need to do this work again until $node changes.
    \Drupal::cache()->set($cid, $marklove, Cache::PERMANENT, $node->getCacheTags());

    return $marklove;

  }

}
