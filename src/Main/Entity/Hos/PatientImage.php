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
 * @Table(name="patient_image")
 */
class PatientImage extends BaseEntity {
    /**
     * @Id
     * @Column(type="string")
     */
    protected $hn;

    /**
     * @Column(type="string")
     */
    protected $image_name;

    /**
     * @Column(type="blob")
     */
    protected $image;

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
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image_name
     */
    public function setImageName($image_name)
    {
        $this->image_name = $image_name;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->image_name;
    }

} 