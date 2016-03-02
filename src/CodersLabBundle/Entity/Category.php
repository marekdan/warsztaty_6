<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=100)
     */
    private $categoryName;

    /**
     * @ORM\ManyToOne(targetEntity= "User", inversedBy= "categories")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id")
     */
    private $users;
//, onDelete="CASCADE"

    /**
     * @ORM\OneToMany(targetEntity = "Tasks", mappedBy = "category")
     */
    private $task;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName() {
        return $this->categoryName;
    }

    /**
     * Set users
     *
     * @param \CodersLabBundle\Entity\User $users
     * @return Category
     */
    public function setUsers(\CodersLabBundle\Entity\User $users = null) {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \CodersLabBundle\Entity\User
     */
    public function getUsers() {
        return $this->users;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->task = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add task
     *
     * @param \CodersLabBundle\Entity\Task $task
     * @return Category
     */
    public function addTask(\CodersLabBundle\Entity\Task $task) {
        $this->task[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \CodersLabBundle\Entity\Task $task
     */
    public function removeTask(\CodersLabBundle\Entity\Task $task) {
        $this->task->removeElement($task);
    }

    /**
     * Get task
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTask() {
        return $this->task;
    }
}
