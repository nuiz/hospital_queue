<?php
/**
 * Created by PhpStorm.
 * User: Papangping
 * Date: 11/14/14
 * Time: 4:55 AM
 */

namespace Main\Entity\Que;

/**
 * @Entity
 * @Table(name="setting")
 */
class Setting extends BaseEntity {
    /** @Column(type="string") */
    protected $background_path;

    /** @Column(type="boolean") */
    protected $show_people_name;

    /**
     * @param mixed $background_path
     */
    public function setBackgroundPath($background_path)
    {
        $this->background_path = $background_path;
    }

    /**
     * @return mixed
     */
    public function getBackgroundPath()
    {
        return $this->background_path;
    }

    /**
     * @param mixed $show_people_name
     */
    public function setShowPeopleName($show_people_name)
    {
        $this->show_people_name = $show_people_name;
    }

    /**
     * @return mixed
     */
    public function getShowPeopleName()
    {
        return $this->show_people_name;
    }


} 