<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 31/10/2557
 * Time: 11:11 น.
 */

namespace Main\Entity\Hos;

/**
 * @Entity
 * @Table(name="patient")
 */
class Patient extends BaseEntity {
    /**
     * @Id
     * @Column(type="string")
     */
    protected $hos_guid;

    /**
     * @Column(type="string")
     */
    protected $hn;

    /**
     * @Column(type="string")
     */
    protected $fname;

    /**
     * @Column(type="string")
     */
    protected $lname;

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


} 