<?php

namespace CodersLabBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CodersLabBundle\Entity\Category;
use CodersLabBundle\Entity\Tasks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController
 * @package CodersLabBundle\Controller
 * @Route("/task")
 */
class TasksController extends Controller {

    public function generateFormTask($task, $action) {
        $form = $this->createFormBuilder($task);
        $form->add('name', 'text');
        $form->add('description', 'text');
        $form->add('priority', 'choice', ['label'    => 'select priority',
                                'multiple' => false,
                                'choices'  => [1 => '1', 2 => '2', 3 => '3',]]);
        $form->add('save', 'submit', ['label' => 'Submit']);
        $form->setAction($action);
        $formTask = $form->getForm();

        return $formTask;
    }

    /**
     * @Route("/addTask/{categoryId}", name = "addTask")
     * @Method("GET")
     * @Template("CodersLabBundle:Tasks:addTask.html.twig")
     */
    public function addTaskAction($categoryId) {
        $task = new Tasks();
        $action = $this->generateUrl('addTask', ['categoryId' => $categoryId]);
        $taskForm = $this->generateFormTask($task, $action);

        return ['taskForm' => $taskForm->createView()];
    }

    /**
     * @Route("/addTask/{categoryId}", name = "addTaskSave")
     * @Method("POST")
     */
    public function addTaskSaveAction(Request $reg, $categoryId) {
        $task = new Tasks();
        $action = $this->generateUrl('addTask', ['categoryId' => $categoryId]);
        $taskForm = $this->generateFormTask($task, $action);
        $taskForm->handleRequest($reg);

        if ($taskForm->isSubmitted()) {
            $categoryRepo = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
            $category = $categoryRepo->find($categoryId);
            $task->setCategory($category);
            $task->setDate(date('G:i:s Y-m-t'));
            $task->setStatus('todo');

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        return $this->redirectToRoute('mainSite');
    }

    /**
     * @Route("/showTask", name = "showTask")
     * @Template()
     */
    public function showTaskAction() {
        return [];
    }

    /**
     * @Route("/showAllTasks", name ="showAllTasks")
     * @Template()
     */
    public function showAllTasksAction() {
        return [];
    }

}
