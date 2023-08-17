<?php

namespace Drupal\color_template\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Color Template Task Module Module routes.
 */
class ColorTemplateController extends ControllerBase {
  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructor for the ConfigFactory service.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    $config = $this->configFactory->getEditable('color_template.settings');
    $title = $config->get('title');
    $text = strip_tags($config->get('paragraph')['value']);
    $color = $config->get('color');

    return [
      '#theme' => 'custom_template',
      '#title' => $title,
      '#text' => $text,
      '#color' => $color,
    ];
  }

}
