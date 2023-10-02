<?php
namespace ECidade\V3\Extension;

use \ECidade\V3\Extension\Storage;

/**
 * @package core
 */
abstract class AbstractMetadata  {

  /**
   * @var Storage
   */
  private $storage;

  /**
   * @var string $path
   */
  public function __construct($path, $sufix = '.data') {
    $this->storage = new Storage($path . $sufix);
  }

  /**
   * @return Storage
   */
  public function getStorage() {
    return $this->storage;
  }

  public function getPath() {
    return $this->getStorage()->getPath();
  }

  public function exists() {
    return $this->getStorage()->exists();
  }

  public function remove() {
    return $this->getStorage()->remove();
  }

  /**
   * @return boolean
   */
  public function save() {

    $storage = $this->getStorage();
    $storage->setData($this);
    return $storage->save();
  }

  /**
   * @return AbstractMetadata
   */
  public static function restore($path = null) {
    $instance = new static($path);
    $storage = $instance->getStorage();
    if ($storage->exists()) {

      $absolutePath = $instance->getPath();
      $storage->load();

      $instance = $storage->getData();

      //@fixme as vezes $instance retorna null precisa ser investigado com mais calma
      if (!$instance) {
        $instance = new static($path);
      }

      $instance->getStorage()->setPath($absolutePath);
    }

    return $instance;
  }

}
