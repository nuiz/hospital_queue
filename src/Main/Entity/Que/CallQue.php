<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 6/12/14
 * Time: 3:06 PM
 */

namespace Main\Entity\Que;


/**
 * @Entity
 * @Table(name="call_que")
 */
class CallQue extends BaseEntity {
    /** @Column(type="string") */
    protected $fname;

    /** @Column(type="string") */
    protected $lname;

    /** @Column(type="string") */
    protected $prefix1_path;

    /** @Column(type="string") */
    protected $prefix2_path;

    /** @Column(type="string") */
    protected $prefix3_path;

    /**
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    }

    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->fname;
    }

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
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    }

    /**
     * @return mixed
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * @param mixed $prefix1_path
     */
    public function setPrefix1Path($prefix1_path)
    {
        $this->prefix1_path = $prefix1_path;
    }

    /**
     * @return mixed
     */
    public function getPrefix1Path()
    {
        return $this->prefix1_path;
    }

    /**
     * @param mixed $prefix2_path
     */
    public function setPrefix2Path($prefix2_path)
    {
        $this->prefix2_path = $prefix2_path;
    }

    /**
     * @return mixed
     */
    public function getPrefix2Path()
    {
        return $this->prefix2_path;
    }

    /**
     * @param mixed $prefix3_path
     */
    public function setPrefix3Path($prefix3_path)
    {
        $this->prefix3_path = $prefix3_path;
    }

    /**
     * @return mixed
     */
    public function getPrefix3Path()
    {
        return $this->prefix3_path;
    }


}