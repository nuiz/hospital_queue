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
    protected $hn;

    /** @Column(type="string") */
    protected $fname;

    /** @Column(type="string") */
    protected $lname;

    /** @Column(type="string", nullable=true) */
    protected $spclty;

    /** @Column(type="string") */
    protected $prefix1_id;

    /** @Column(type="string") */
    protected $prefix2_id;

    /** @Column(type="string") */
    protected $prefix3_id;

    /**
     * @param mixed $hn
     */
    public function setHn($hn)
    {
        $this->hn = $hn;
    }

    /**
     * @return mixed
     */
    public function getHn()
    {
        return $this->hn;
    }

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
     * @param mixed $prefix1_id
     */
    public function setPrefix1Id($prefix1_id)
    {
        $this->prefix1_id = $prefix1_id;
    }

    /**
     * @return mixed
     */
    public function getPrefix1Id()
    {
        return $this->prefix1_id;
    }

    /**
     * @param mixed $prefix2_id
     */
    public function setPrefix2Id($prefix2_id)
    {
        $this->prefix2_id = $prefix2_id;
    }

    /**
     * @return mixed
     */
    public function getPrefix2Id()
    {
        return $this->prefix2_id;
    }

    /**
     * @param mixed $prefix3_id
     */
    public function setPrefix3Id($prefix3_id)
    {
        $this->prefix3_id = $prefix3_id;
    }

    /**
     * @return mixed
     */
    public function getPrefix3Id()
    {
        return $this->prefix3_id;
    }

    /**
     * @param mixed $spclty
     */
    public function setSpclty($spclty)
    {
        $this->spclty = $spclty;
    }

    /**
     * @return mixed
     */
    public function getSpclty()
    {
        return $this->spclty;
    }
}