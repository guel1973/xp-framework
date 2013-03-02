<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'peer.ftp.server.storage.Storage',
    'net.xp_framework.unittest.peer.ftp.TestingCollection',
    'net.xp_framework.unittest.peer.ftp.TestingElement'
  );

  /**
   * Memory storage used
   *
   * @see   xp://net.xp_framework.unittest.peer.ftp.TestingServer
   */
  class TestingStorage extends Object implements Storage {
    protected $base= array();
    public $entries= array();

    /**
     * Sets base
     *
     * @param  int clientId
     * @param  string uri
     */
    public function setBase($clientId, $uri) {
      $this->base[$clientId]= rtrim($uri, '/').'/';
    }

    /**
     * Gets base
     *
     * @param  int clientId
     * @return string uri
     */
    public function getBase($clientId) {
      if (!isset($this->base[$clientId])) {
        $this->base[$clientId]= '/';
      }
      return $this->base[$clientId];
    }


    /**
     * Normalize a given URI
     *
     * @param   string uri
     * @return  string
     */
    protected function normalize($uri) {
      $r= '';
      $o= 0;
      $l= strlen($uri);
      do {
        $p= strcspn($uri, '/', $o);
        $element= substr($uri, $o, $p);
        if ('' === $element || '.' === $element) {
          // NOOP
        } else if ('..' === $element) {
          $r= substr($r, 0, strrpos($r, '/', -2)).'/';
        } else {
          $r.= $element.'/';
        }
        $o+= $p+ 1;
      } while ($o < $l);
      return '/'.rtrim($r, '/');
    }

    /**
     * Gets an entry
     *
     * @param  int clientId
     * @param  string uri
     * @param  int type
     * @return peer.ftp.server.storage.StorageEntry
     */
    public function createEntry($clientId, $uri, $type) {
      $qualified= $this->normalize($this->base[$clientId].$uri);
      switch ($type) {
        case ST_ELEMENT:
          $this->entries[$qualified]= new TestingElement($qualified, $this);
          break;

        case ST_COLLECTION:
          $this->entries[$qualified]= new TestingCollection($qualified, $this);
          break;
      }
      return $this->entries[$qualified];
    }

    /**
     * Looks up an entry
     *
     * @param  int clientId
     * @param  string uri
     * @return peer.ftp.server.storage.StorageEntry
     */
    public function lookup($clientId, $uri) {
      $qualified= $this->normalize($this->base[$clientId].$uri);
      // Logger::getInstance()->getCategory()->warn('*** LOOKUP', $qualified, $this->entries[$qualified]);
      return isset($this->entries[$qualified]) ? $this->entries[$qualified] : NULL;
    }

    /**
     * Creates an entry
     *
     * @param  int clientId
     * @param  string uri
     * @param  int type
     * @return peer.ftp.server.storage.StorageEntry
     */
    public function create($clientId, $uri, $type) {
      $qualified= $this->normalize($this->base[$clientId].$uri);
      switch ($type) {
        case ST_ELEMENT:
          $this->entries[$qualified]= new TestingElement($qualified, $this);
          break;

        case ST_COLLECTION:
          $this->entries[$qualified]= new TestingCollection($qualified, $this);
          break;
      }
      return $this->entries[$qualified];
    }
  }
?>
