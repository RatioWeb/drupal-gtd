<?php

namespace Drupal\custom_endpoints\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;

/**
 *
 */
class ApiController extends ControllerBase {
  public function getNode(Request $request, $node) {
    if ($entity = $this->entityTypeManager()->getStorage('node')->load($node)) {
      $output = $entity->toArray();

      $response = new CacheableJsonResponse($output);
      $response->addCacheableDependency($entity);

      return $response;
    }
    else {
      return new Response($this->t('No node found'), Response::HTTP_NOT_FOUND);
    }
  }


  public function getNodes(Request $request) {
    $output = [];
    $query = \Drupal::entityQuery('node');

    $query->condition('status', TRUE);
    $query->pager(1);
    $ids = $query->execute();

    $entities = $this->entityTypeManager()->getStorage('node')->loadMultiple($ids);

    foreach ($entities as $entity) {
      $output[] = [
        'nid' => $entity->nid->value,
        'title' => $entity->title->value,
      ];
    }

    $response = new CacheableJsonResponse($output);

    foreach ($entities as $entity) {
      $response->addCacheableDependency($entity);
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

  public function updateNode(Request $request, $node) {
    if ($entity = $this->entityTypeManager()->getStorage('node')->load($node)) {
      $content = json_decode($request->getContent());

      $entity->set('title', $content->title);
      $entity->save();

      return new Response($this->t('Node updated'), Response::HTTP_OK);
    }
    else {
      return new Response($this->t('No node found'), Response::HTTP_NOT_FOUND);
    }
  }
}
