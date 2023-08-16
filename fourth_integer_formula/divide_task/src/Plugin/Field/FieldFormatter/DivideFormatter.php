<?php

namespace Drupal\divide_task\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'divide_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "divide_formatter",
 *   label = @Translation("Divide Formatter"),
 *   field_types = {
 *     "integer"
 *   }
 * )
 */
class DivideFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $value = $item->value / 100;
      $elements[$delta] = [
        '#markup' => '<p>' . $value . '</p>',
      ];
    }

    return $elements;

  }

}
