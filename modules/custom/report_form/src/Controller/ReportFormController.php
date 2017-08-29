<?php

namespace Drupal\report_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Node\NodeTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ReportFormController.
 */
class ReportFormController extends ControllerBase {


  /**
   * @var QueryFactory
   */
  protected $queryFactory;

  /**
   * @var EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query'),
      $container->get('entity_type.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function content(Request $request) {
    $type = $this->entityTypeManager();
    $node = $this->entityManager()->getStorage('node')->create([
      'type' => 'user_report',
    ]);
    $node_create_form = $this->entityFormBuilder()->getForm($node);

    return [
      '#type' => 'markup',
      '#markup' => render($node_create_form),
    ];
  }

}
