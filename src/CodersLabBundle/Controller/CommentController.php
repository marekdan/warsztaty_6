<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController
 * @package CodersLabBundle\Controller
 * @Route("/comment")
 */
class CommentController extends Controller {

    public function generateFormComment($comment, $action) {
        $form = $this->createFormBuilder($comment);
        $form->add('commentText', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);
        $form->setAction($action);
        $commentForm = $form->getForm();

        return $commentForm;
    }


    /**
     * @Route("/addComment/{taskId}", name = "addComment")
     * @Template()
     * @Method("GET")
     */
    public function addCommentAction($taskId) {
        $category = new Comment();
        $action = $this->generateUrl('addComment', ['taskId' => $taskId]);
        $commentForm = $this->generateFormComment($category, $action);

        return ['commentForm' => $commentForm->createView()];
    }

    /**
     * @Route("/addComment/{taskId}", name = "addCommentSave")
     * @Method("POST")
     */
    public function addCommentSaveAction(Request $reg, $taskId) {
        $comment = new Comment();
        $action = $this->generateUrl('addComment', ['taskId' => $taskId]);
        $commentForm = $this->generateFormComment($comment, $action);
        $commentForm->handleRequest($reg);

        if ($commentForm->isSubmitted()) {
            $repoTasks = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
            $task = $repoTasks->find($taskId);
            $comment->setTask($task);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirectToRoute('showComments', ['taskId' => $taskId]);
    }

    /**
     * @Route("/showComments/{taskId}", name = "showComments")
     * @Template()
     */
    public function showCommentsAction($taskId) {
        $repoTask = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $task = $repoTask->find($taskId);
        $repoComments = $this->getDoctrine()->getRepository('CodersLabBundle:Comment');
        $comments = $repoComments->findByTask($task);

        return ['comments' => $comments, 'task' => $task];
    }

    /**
     * @Route("/deleteComment/{commentId}/{taskId}", name = "deleteComment")
     */
    public function deleteCommentAction($commentId, $taskId) {
        $repoComment = $this->getDoctrine()->getRepository('CodersLabBundle:Comment');
        $comment = $repoComment->find($commentId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('showComments', ['taskId' => $taskId]);
    }

}
