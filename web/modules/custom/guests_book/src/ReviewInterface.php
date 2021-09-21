<?php

namespace Drupal\guests_book;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Contact entity.
 *
 * @ingroup guests_book
 */
interface ReviewInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {
}
