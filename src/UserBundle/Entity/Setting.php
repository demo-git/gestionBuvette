<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity()
 */
class Setting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="warningWait", type="integer")
     */
    private $warningWait;

    /**
     * @var int
     *
     * @ORM\Column(name="dangerWait", type="integer")
     */
    private $dangerWait;

    /**
     * @var int
     *
     * @ORM\Column(name="hovenCapacity", type="integer")
     */
    private $hovenCapacity;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set warningWait
     *
     * @param integer $warningWait
     *
     * @return Setting
     */
    public function setWarningWait($warningWait)
    {
        $this->warningWait = $warningWait;

        return $this;
    }

    /**
     * Get warningWait
     *
     * @return int
     */
    public function getWarningWait()
    {
        return $this->warningWait;
    }

    /**
     * Set dangerWait
     *
     * @param integer $dangerWait
     *
     * @return Setting
     */
    public function setDangerWait($dangerWait)
    {
        $this->dangerWait = $dangerWait;

        return $this;
    }

    /**
     * Get dangerWait
     *
     * @return int
     */
    public function getDangerWait()
    {
        return $this->dangerWait;
    }

    /**
     * Set hovenCapacity
     *
     * @param integer $hovenCapacity
     *
     * @return Setting
     */
    public function setHovenCapacity($hovenCapacity)
    {
        $this->hovenCapacity = $hovenCapacity;

        return $this;
    }

    /**
     * Get hovenCapacity
     *
     * @return int
     */
    public function getHovenCapacity()
    {
        return $this->hovenCapacity;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Setting
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}
