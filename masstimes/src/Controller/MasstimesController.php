<?php

namespace Drupal\masstimes\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for masstimes routes.
 */
class MasstimesController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
