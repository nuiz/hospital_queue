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
    protected $rxdate;

    /** @Column(type="time") */
    protected $rxtime;

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
     * @param mixed $rxdate
     */
    public function setRxdate($rxdate)
    {
        $this->rxdate = $rxdate;
    }

    /**
     * @return mixed
     */
    public function getRxdate()
    {
        return $this->rxdate;
    }

    /**
     * @param mixed $rxtime
     */
    public function setRxtime($rxtime)
    {
        $this->rxtime = $rxtime;
    }

    /**
     * @return mixed
     */
    public function getRxtime()
    {
        return $this->rxtime;
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
}