<?php

namespace Drupal\ar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;
Use \Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use Drupal\Core\Database\Query\PagerSelectExtender;

/**
 * This is our guest book controller.
 */
class ArController extends ControllerBase {

  /**
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityBuild;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
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
   * Render the form.
   */
  public function content() {
    $comments = [];

    $ar_storage = \Drupal::entityTypeManager()->getStorage('ar');
    $entity = $ar_storage->create();
    $ar_form = $this->entityFormBuilder()->getForm($entity, 'add');
    $entity_id = $ar_storage->getQuery()
      ->sort('created', 'DESC')
      ->pager(5)
      ->execute();

    $view = \Drupal::entityTypeManager()->getViewBuilder('ar');
    $reviews = $ar_storage->loadMultiple($entity_id);

    foreach ($reviews as $review) {
      $comments[] = $view->view($review);
    }

//    $pager = [
//      '#type' => 'pager',
//    ];

    return [
      '#theme' => 'ar_page',
      '#form' => $ar_form,
      '#review' => $comments,
//      '#pager' => $pager,
      '#pager' => [
        '#type' => 'pager',
      ],
    ];
  }

}
