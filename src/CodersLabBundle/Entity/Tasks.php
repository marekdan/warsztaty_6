<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Tasks
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\TasksRepository")
 */
class Tasks {

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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity = "Category", inversedBy = "task")
     * @ORM\JoinColumn(name = "category_id", referencedColumnName = "id", onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity = "Comment", mappedBy = "task")
     */
    private $comments;

    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Get id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     * @return Tasks
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     * @param string $description
     * @return Tasks
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set date
     * @param \DateTime $date
     * @return Tasks
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set priority
     * @param integer $priority
     * @return Tasks
     */
    public function setPriority($priority) {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     * @return integer
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * Set status
     * @param string $status
     * @return Tasks
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set category
     * @param \CodersLabBundle\Entity\Category $category
     * @return Tasks
     */
    public function setCategory(\CodersLabBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     * @return \CodersLabBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Add comments
     * @param \CodersLabBundle\Entity\Comment $comments
     * @return Tasks
     */
    public function addComment(\CodersLabBundle\Entity\Comment $comments) {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     * @param \CodersLabBundle\Entity\Comment $comments
     */
    public function removeComment(\CodersLabBundle\Entity\Comment $comments) {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments() {
        return $this->comments;
    }
}
