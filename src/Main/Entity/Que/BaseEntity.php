<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/5/14
 * Time: 2:10 PM
 */

namespace Main\Entity\Que;

/**
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
class BaseEntity implements \JsonSerializable {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="datetime") */
    protected $created_at;

    /** @Column(type="datetime") */
    protected $updated_at;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /** @PrePersist */
    public function doStuffOnPrePersist(){
        $now = new \DateTime("now");
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
    }

    /** @PreUpdate */
    public function doStuffOnPreUpdate(){
        $now = new \DateTime("now");
        $this->setUpdatedAt($now);
    }

    public function __construct($attr = array()){
        $this->importAttr($attr);
    }

    public function importAttr($attr = array()){
        foreach($attr as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

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
        $item = $this->toArray();
        foreach($item as $key=> $value){
            if($value instanceof \DateTime){
                $item[$key] = $value->getTimestamp();
            }
        }

        return $item;
    }
}