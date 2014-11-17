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

    /** @Column(type="boolean") */
    protected $hide_after_call;

    /** @Column(type="boolean") */
    protected $call_after_scan;

    /** @Column(type="integer") */
    protected $auto_hide_time;

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

    /**
     * @param mixed $auto_hide_time
     */
    public function setAutoHideTime($auto_hide_time)
    {
        $this->auto_hide_time = $auto_hide_time;
    }

    /**
     * @return mixed
     */
    public function getAutoHideTime()
    {
        return $this->auto_hide_time;
    }

    /**
     * @param mixed $call_after_scan
     */
    public function setCallAfterScan($call_after_scan)
    {
        $this->call_after_scan = $call_after_scan;
    }

    /**
     * @return mixed
     */
    public function getCallAfterScan()
    {
        return $this->call_after_scan;
    }

    /**
     * @param mixed $hide_after_call
     */
    public function setHideAfterCall($hide_after_call)
    {
        $this->hide_after_call = $hide_after_call;
    }

    /**
     * @return mixed
     */
    public function getHideAfterCall()
    {
        return $this->hide_after_call;
    }


} 