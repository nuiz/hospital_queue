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
 * @Table(name="spclty")
 */
class Spclty extends BaseEntity {
    /**
     * @Id
     * @Column(type="string", length=2, options={"fixed" = true})
     */
    protected $spclty;

    /** @Column(type="string", length=150) */
    protected $name;

    /** @Column(type="string", length=3, options={"fixed" = true}) */
    protected $depcode;

    /** @Column(type="string", length=150) */
    protected $spname;

    /** @Column(type="string", length=10) */
    protected $shortname;

    /**
     * @param mixed $depcode
     */
    public function setDepcode($depcode)
    {
        $this->depcode = $depcode;
    }

    /**
     * @return mixed
     */
    public function getDepcode()
    {
        return $this->depcode;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $shortname
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;
    }

    /**
     * @return mixed
     */
    public function getShortname()
    {
        return $this->shortname;
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
     * @param mixed $spname
     */
    public function setSpname($spname)
    {
        $this->spname = $spname;
    }

    /**
     * @return mixed
     */
    public function getSpname()
    {
        return $this->spname;
    }


} 