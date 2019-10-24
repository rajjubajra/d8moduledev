<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides and RSVP list block
 * @Block(
 *  id = "rsvp_block"
 *  admin_label = @Translation("RSVP Block"),
 * )
 */

class RSVPBlock extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    return array(
      '#markup' => $this->t('RSVP List Block'),
    );
  }
}