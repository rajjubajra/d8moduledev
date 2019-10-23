<?php
/**
 * @file
 * Contain \Drupal\mymodule\Controller\MyModuleController.
 */

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase{
  public function content(){
    return array(
      '#type' => 'markup',
      '#markup' => t('This is menu link custom page')
    );
  }
}
