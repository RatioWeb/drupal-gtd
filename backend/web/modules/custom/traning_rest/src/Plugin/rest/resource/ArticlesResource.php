<?php 

namespace Drupal\traning_rest\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a Articles Resource
 *
 * @RestResource(
 *   id = "articles_resource",
 *   label = @Translation("Articles Resource"),
 *   uri_paths = {
 *     "canonical" = "/api/rest/articles_resource"
 *   }
 * )
 */
class articlesResource extends ResourceBase {

  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {
    
    $node = \Drupal\node\Entity\Node::load(1);
    
    $response = ['nid' => $node->id(), 'title' => $node->getTitle(), 'custom' => "Some custom content!"];
    return new ResourceResponse($response);
  }
}
