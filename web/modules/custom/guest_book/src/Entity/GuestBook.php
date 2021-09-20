<?php

namespace Drupal\guest_book\Entity;

use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the GuestBook entity.
 *
 * @ingroup guest_book
 *
 * @ContentEntityType(
 *   id = "guest_book",
 *   label = @Translation ("Guest book"),
 *   base_table = "guest_book",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 * )
 */

/**
 * {@inheritdoc}
 */
class GuestBook extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Guest book entity'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Guest book entity.'))
      ->setReadOnly(TRUE);

    return $fields;
  }

}
