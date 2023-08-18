<?php

/**
 * @file
 * Provide views data for node_view.module.
 */

/**
 * Implements hook_views_data_alter().
 */
function node_view_views_data_alter(&$data) {
  $data['node_field_data']['custom_node_link'] = [
    'field' => [
      'title' => t('Add Node Link'),
      'help' => t('Provide a link for the Content.'),
      'id' => 'node_view_node_link',
    ],
  ];
}
