<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TaskController extends Controller
{
    /**
     * @Route("/showTask")
     * @Template()
     */
    public function showTaskAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/showAllTasks")
     * @Template()
     */
    public function showAllTasksAction()
    {
        return array(
                // ...
            );    }

}
