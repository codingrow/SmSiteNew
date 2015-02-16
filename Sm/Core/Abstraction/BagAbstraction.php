<?php
/**
 * User: Samuel
 * Date: 2/2/2015
 * Time: 12:46 PM
 */

namespace Sm\Core\Abstraction;

abstract class BagAbstraction implements \Iterator{
    public $size;
    protected $elements;
    protected $position;
    function __construct() {
        $this->position = 0;
    }

    public function insert($element){
        $this->elements[] = $element;
        $this->size++;
        return $element;
    }
    public function remove($index = null){
        if($index != null){
            $this->elements[$index] = null;
        }else{
            $this->current() = null;
        }
        return true;
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function &current() {
        return $this->elements[$this->position];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
        ++$this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key() {
        return $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return isset($this->elements[$this->position]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        $this->position = 0;
    }
}