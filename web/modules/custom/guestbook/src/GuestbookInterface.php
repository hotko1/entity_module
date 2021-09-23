<?php

namespace Drupal\guestbook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Guestbook entity.
 *
 * @ingroup guestbook
 */
interface GuestbookInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {
}
