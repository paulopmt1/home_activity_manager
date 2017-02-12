<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSystemMakeActivity
 *
 * @ORM\Table(name="user_system_make_activity", indexes={@ORM\Index(name="fk_user_system_make_activity_user_system_idx", columns={"user_system_id"}), @ORM\Index(name="fk_user_system_make_activity_activity1_idx", columns={"activity_id"})})
 * @ORM\Entity
 */
class UserSystemMakeActivity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \Activity
     *
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     * })
     */
    private $activity;

    /**
     * @var \UserSystem
     *
     * @ORM\ManyToOne(targetEntity="UserSystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_system_id", referencedColumnName="id")
     * })
     */
    private $userSystem;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserSystemMakeActivity
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return UserSystemMakeActivity
     */
    public function setActivity(\AppBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set userSystem
     *
     * @param \AppBundle\Entity\UserSystem $userSystem
     *
     * @return UserSystemMakeActivity
     */
    public function setUserSystem(\AppBundle\Entity\UserSystem $userSystem = null)
    {
        $this->userSystem = $userSystem;

        return $this;
    }

    /**
     * Get userSystem
     *
     * @return \AppBundle\Entity\UserSystem
     */
    public function getUserSystem()
    {
        return $this->userSystem;
    }
}
