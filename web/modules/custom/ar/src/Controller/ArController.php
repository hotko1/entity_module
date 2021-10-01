<?php

namespace Drupal\ar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This is our guest book controller.
 */
class ArController extends ControllerBase {

  /**
   * Do some functions.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityBuild;

  /**
   * Do some functions.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $formBuild;

  /**
   * Build entity form.
   *
   * @return \Drupal\ar\Controller\ArController
   *   $example
   */
  public static function create(ContainerInterface $container) {
    $example = parent::create($container);
    $example->formBuild = $container->get('entity.form_builder');
    $example->entityBuild = $container->get('entity_type.manager');

    return $example;
  }

  /**
   * Render the form with comments.
   */
  public function content() {
    $comments = [];

    $ar_storage = \Drupal::entityTypeManager()->getStorage('ar');
    $entity = $ar_storage->create();
    $ar_form = $this->entityFormBuilder()->getForm($entity, 'add');
    $entity_id = $ar_storage->getQuery()
      ->sort('created', 'DESC')
      ->pager(5, 0)
      ->execute();

    $view = \Drupal::entityTypeManager()->getViewBuilder('ar');
    $reviews = $ar_storage->loadMultiple($entity_id);

    foreach ($reviews as $review) {
      $comments[] = $view->view($review);
    }

    return [
      '#theme' => 'ar_page',
      '#form' => $ar_form,
      '#review' => $comments,
      '#contextual_links' => [
        'ar' => [
          'route_parameters' => ['ar' => $entity->id()],
        ],
      ],
      '#pager' => [
        '#type' => 'pager',
      ],
    ];
  }

}
