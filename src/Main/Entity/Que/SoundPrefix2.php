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

    /** @Column(type="string") */
    protected $picture_path;

    /** @Column(type="string") */
    protected $room_name;

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

    /**
     * @param mixed $picture_path
     */
    public function setPicturePath($picture_path)
    {
        $this->picture_path = $picture_path;
    }

    /**
     * @return mixed
     */
    public function getPicturePath()
    {
        return $this->picture_path;
    }

    /**
     * @param mixed $room_name
     */
    public function setRoomName($room_name)
    {
        $this->room_name = $room_name;
    }

    /**
     * @return mixed
     */
    public function getRoomName()
    {
        return $this->room_name;
    }
} 