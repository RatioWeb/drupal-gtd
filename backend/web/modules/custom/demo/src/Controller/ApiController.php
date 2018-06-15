<?php

namespace Drupal\demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheableJsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController.
 */
class ApiController extends ControllerBase {
  /* @var Drupal\Core\Entity\Query\QueryInterface $query */


  public function __construct() {
  }

  /**
   * Example node list.
   */
  public function getNodes() {
    $query = \Drupal::entityQuery('node');
    $title = \Drupal::request()->query->get('title');
    $output = [];

    $query->condition('status', TRUE);
    $query->pager(10);

    if (!empty($title)) {
      $query->condition('title', '%'. $title .'%', 'LIKE');
    }

    $ids = $query->execute();
    $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($ids);

    // Generate output structure.
    foreach ($nodes as $node) {
      $output[] = ['title' => $node->title->value, 'nid' => $node->id()];
    }

    $response = new CacheableJsonResponse($output);

    foreach ($nodes as $node) {
      $response->addCacheableDependency($node);
    }
    $response->addCacheableDependency(
      CacheableMetadata::createFromRenderArray(
        [
          '#cache' => [
            'contexts' => [
              'url.query_args'
            ]
          ],
        ]
      )
    );

    return $response;
  }

  public function addNode() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: node')
    ];
  }

  public function deleteNode() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: node')
    ];
  }

  public function updateNodes() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: node')
    ];
  }

  public function getNode($node) {
    $entity = $this->entityTypeManager()->getStorage('node')->load($node);

    if ($entity) {
      $output = $entity->toArray();
      $response = new CacheableJsonResponse($output);
      $response->addCacheableDependency($entity);
    }
    else {
      $response = new Response($this->t('Content not found'), Response::HTTP_NOT_FOUND);
    }

    return $response;
  }

  public function updateNode(Request $request, $node) {
    $entity = $this->entityTypeManager()->getStorage('node')->load($node);

    if ($entity) {
      $content = json_decode($request->getContent());
      $entity->set('title', $content->title);
      $entity->save();
      return new Response($this->t('All is OK'), Response::HTTP_OK);
    }
    else {
      return new Response($this->t('No node found'), Response::HTTP_NOT_FOUND);
    }
  }


}
