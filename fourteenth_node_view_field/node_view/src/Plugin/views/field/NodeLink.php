<?php

namespace Drupal\node_view\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Handler for showing node link.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("node_view_node_link")
 */
class NodeLink extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['text'] = ['default' => $this->getDefaultLabel()];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['node_id'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Select a Node'),
      '#target_type' => 'node',
      '#required' => TRUE,
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function query() {}

  /**
   * Returns the default label for the link.
   *
   * @return string
   *   The default link label.
   */
  protected function getDefaultLabel() {
    return $this->t('Node');
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $this->getEntity($values);

    if (!$node) {
      return '';
    }

    $url = Url::fromRoute('node_view.node_link', [
      'node' => $node->id(),
    ]);

    if (!$url->access()) {
      return '';
    }

    return [
      '#type' => 'link',
      '#url' => $url,
      '#title' => $this->options['text'] ?: $this->getDefaultLabel(),
    ];
  }

}
