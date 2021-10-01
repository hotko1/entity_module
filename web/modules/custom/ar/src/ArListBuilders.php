<?php

namespace Drupal\ar;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for ar_review entity.
 */
class ArListBuilders extends EntityListBuilder {

  /**
   * {@inheritdoc}
   *
   * Build the header and content lines for the review list.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ReviewID');
    $header['name_user'] = $this->t('User Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->id();
    $row['name_user'] = $entity->toLink()->toString();
    return $row + parent::buildRow($entity);
  }

}
