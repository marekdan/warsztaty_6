<?php

namespace CodersLabBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CommentController extends Controller {

    /**
     * @Route("/showComments/{taskId}", name = "showComments")
     * @Template()
     */
    public function showCommentsAction($taskId) {
        $taskRepo = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $task = $taskRepo->find($taskId);



        return ['task'=>$task];
    }

    /**
     * @Route("/addComment/{taskId}", name = "addComment")
     * @Template()
     */
    public function addCommentAction($taskId) {

        return [];
    }
}
