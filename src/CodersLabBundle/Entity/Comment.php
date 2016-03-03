<?php

namespace CodersLabBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CodersLabBundle\Entity\CommentRepository")
 */
class Comment {

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
     * @ORM\Column(name="commentText", type="text")
     */
    private $commentText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity = "Tasks", inversedBy = "comments")
     * @ORM\JoinColumn(name = "task_id", referencedColumnName = "id")
     */
    private $task;

    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set commentText
     *
     * @param string $commentText
     * @return Comment
     */
    public function setCommentText($commentText) {
        $this->commentText = $commentText;

        return $this;
    }

    /**
     * Get commentText
     *
     * @return string
     */
    public function getCommentText() {
        return $this->commentText;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set task
     *
     * @param \CodersLabBundle\Entity\Tasks $task
     * @return Comment
     */
    public function setTask(\CodersLabBundle\Entity\Tasks $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \CodersLabBundle\Entity\Tasks 
     */
    public function getTask()
    {
        return $this->task;
    }
}
