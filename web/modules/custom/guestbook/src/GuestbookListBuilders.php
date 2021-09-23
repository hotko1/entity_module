<?php

namespace Drupal\guestbook;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for guests_book_review entity.
 */
class GuestbookListBuilders extends EntityListBuilder {

//  /**
//   * {@inheritdoc}
//   *
//   * We override ::render() so that we can add our own content above the table.
//   * parent::render() is where EntityListBuilder creates the table using our
//   * buildHeader() and buildRow() implementations.
//   */
//  public function render() {
//    $build['description'] = [
//      '#markup' => $this->t('Guests Book implements a Reviews model. These
//      reviews are fieldable entities. You can manage the field on the <a href="@adminlink">
//      Contacts admin page</a>.', [
//        '@adminlink' => \Drupal::urlGenerator()
//          ->generateFromRoute('guestbook.review_settings'),
//      ]),
//    ];
//
//    $build += parent::render();
//    return $build;
//  }

  /**
   * {@inheritdoc}
   *
   * Build the header and content lines for the review list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
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
