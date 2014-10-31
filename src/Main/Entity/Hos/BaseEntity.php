<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/5/14
 * Time: 2:10 PM
 */

namespace Main\Entity\Hos;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
class BaseEntity implements \JsonSerializable {
    public function toArray(){
        return get_object_vars($this);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}