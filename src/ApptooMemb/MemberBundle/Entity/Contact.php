<?php

namespace ApptooMemb\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ApptooMemb\MemberBundle\Entity\ContactRepository")
 */
class Contact
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ApptooMemb\MemberBundle\Entity\Member")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="ApptooMemb\MemberBundle\Entity\Member")
     */
    private $contact;

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
     * Set member
     *
     * @param \ApptooMemb\MemberBundle\Entity\Member $member
     * @return Contact
     */
    public function setMember(\ApptooMemb\MemberBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \ApptooMemb\MemberBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set contact
     *
     * @param integer $contact
     * @return Contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return integer 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
