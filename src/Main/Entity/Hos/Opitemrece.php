<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 1/11/2557
 * Time: 10:57 น.
 */

namespace Main\Entity\Hos;

/**
 * @Entity
 * @Table(name="opitemrece")
 */
class Opitemrece extends BaseEntity {
    /**
     * @Id
     * @Column(type="string", length=38)
     */
    protected $hos_guid;

    /** @Column(type="string") */
    protected $vn;

    /** @Column(type="string") */
    protected $hn;

    /** @Column(type="date") */
    protected $vstdate;

    /** @Column(type="time") */
    protected $vsttime;

    /** @Column(type="string", length=2, options={"fixed" = true}) */
    protected $spclty;

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
     * @param mixed $hos_guid
     */
    public function setHosGuid($hos_guid)
    {
        $this->hos_guid = $hos_guid;
    }

    /**
     * @return mixed
     */
    public function getHosGuid()
    {
        return $this->hos_guid;
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

    /**
     * @param mixed $vn
     */
    public function setVn($vn)
    {
        $this->vn = $vn;
    }

    /**
     * @return mixed
     */
    public function getVn()
    {
        return $this->vn;
    }

    /**
     * @param mixed $vstdate
     */
    public function setVstdate($vstdate)
    {
        $this->vstdate = $vstdate;
    }

    /**
     * @return mixed
     */
    public function getVstdate()
    {
        return $this->vstdate;
    }

    /**
     * @param mixed $vsttime
     */
    public function setVsttime($vsttime)
    {
        $this->vsttime = $vsttime;
    }

    /**
     * @return mixed
     */
    public function getVsttime()
    {
        return $this->vsttime;
    }


}