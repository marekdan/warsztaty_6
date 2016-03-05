<?php

// src/CodersLabBundle/Entity/User.php

namespace CodersLabBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity = "Category", mappedBy = "users")
     */
    private $categories;

    public function __construct() {
        parent::__construct();
    }


    /**
     * Add categories
     * @param \CodersLabBundle\Entity\Category $categories
     * @return User
     */
    public function addCategory(\CodersLabBundle\Entity\Category $categories) {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     * @param \CodersLabBundle\Entity\Category $categories
     */
    public function removeCategory(\CodersLabBundle\Entity\Category $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }
}
