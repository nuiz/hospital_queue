<?php
/**
 * Created by PhpStorm.
 * User: p2
 * Date: 28/10/2557
 * Time: 16:59 น.
 */

namespace Main\Entity\Que;

/**
 * @Entity
 * @Table(name="sound_prefix_2")
 */
class SoundPrefix2 extends BaseEntity {
    /** @Column(type="string") */
    protected $name;

    /** @Column(type="string") */
    protected $path;

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
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }


} 