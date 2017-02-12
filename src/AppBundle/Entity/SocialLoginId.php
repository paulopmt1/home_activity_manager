<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialLoginId
 *
 * @ORM\Table(name="social_login_id", indexes={@ORM\Index(name="fk_social_login_id_user_system1_idx", columns={"user_system_id"})})
 * @ORM\Entity
 */
class SocialLoginId
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
     * @var string
     *
     * @ORM\Column(name="social_network", type="string", length=100, nullable=false)
     */
    private $socialNetwork;

    /**
     * @var string
     *
     * @ORM\Column(name="social_user_id", type="string", length=250, nullable=false)
     */
    private $socialUserId;

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
     * Set socialNetwork
     *
     * @param string $socialNetwork
     *
     * @return SocialLoginId
     */
    public function setSocialNetwork($socialNetwork)
    {
        $this->socialNetwork = $socialNetwork;

        return $this;
    }

    /**
     * Get socialNetwork
     *
     * @return string
     */
    public function getSocialNetwork()
    {
        return $this->socialNetwork;
    }

    /**
     * Set socialUserId
     *
     * @param string $socialUserId
     *
     * @return SocialLoginId
     */
    public function setSocialUserId($socialUserId)
    {
        $this->socialUserId = $socialUserId;

        return $this;
    }

    /**
     * Get socialUserId
     *
     * @return string
     */
    public function getSocialUserId()
    {
        return $this->socialUserId;
    }

    /**
     * Set userSystem
     *
     * @param \AppBundle\Entity\UserSystem $userSystem
     *
     * @return SocialLoginId
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
