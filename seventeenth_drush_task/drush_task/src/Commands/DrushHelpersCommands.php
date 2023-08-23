<?php

namespace Drupal\drush_task\Commands;

use Drush\Commands\DrushCommands;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Command to get editor role active users.
 */
class DrushHelpersCommands extends DrushCommands {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a new CustomMaintenanceCommand object.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(StateInterface $state) {
    parent::__construct();
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  /**
   * Command that returns a list of all active-users.
   *
   * @usage drush-helpers:site-maintenance
   *   Enables site maintenance
   *
   * @command drush site-maintenance
   * @aliases sm
   */
  public function siteMaintenance() {
    $maintenance_mode = $this->state->get('system.maintenance_mode', FALSE);

    if ($maintenance_mode) {
      $this->state->set('system.maintenance_mode', FALSE);
      $this->output()->writeln('Site is now live.');
    }
    else {
      $this->state->set('system.maintenance_mode', TRUE);
      $this->output()->writeln('Site is now in maintenance mode.');
    }
  }

}
