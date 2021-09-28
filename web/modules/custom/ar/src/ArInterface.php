<?php

namespace Drupal\ar;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Ar entity.
 *
 * @ingroup ar
 */
interface ArInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {
}
