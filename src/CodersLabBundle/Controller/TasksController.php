<?php

namespace CodersLabBundle\Controller;


use \DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CodersLabBundle\Entity\Category;
use CodersLabBundle\Entity\Tasks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskController
 * @package CodersLabBundle\Controller
 * @Route("/tasks")
 */
class TasksController extends Controller {

    public function generateFormTask($task, $action) {
        $form = $this->createFormBuilder($task);
        $form->add('name', 'text');
        $form->add('description', 'text');
        $form->add('priority', 'choice', [
            'label'    => 'Priority',
            'multiple' => false,
            'choices'  => [1 => '1', 2 => '2', 3 => '3'
            ]]);
        $form->add('date', 'date', [
            'input'  => 'datetime',
            'widget' => 'single_text',
            'attr'   => [
                'class' => 'calendar'
            ]]);
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
            $task->setStatus('To do');

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        return $this->redirectToRoute('showCategory', ['categoryId' => $categoryId, 'which' => 3]);
    }

    public function generateEditFormTask($task, $action) {
        $form = $this->createFormBuilder($task);
        $form->add('name', 'text');
        $form->add('description', 'text');
        $form->add('priority', 'choice', [
            'label'    => 'Priority',
            'multiple' => false,
            'choices'  => [
                1 => '1', 2 => '2', 3 => '3'
            ]]);
        $form->add('status', 'choice', [
            'label'    => 'Status',
            'multiple' => false,
            'choices'  => [
                'Done' => 'Done', 'To do' => 'To do'
            ]]);
        $form->add('date', 'date', [
            'input'  => 'datetime',
            'widget' => 'single_text',
            'attr'   => [
                'class' => 'calendar'
            ]]);
        $form->add('save', 'submit', ['label' => 'Submit']);
        $form->setAction($action);
        $formTask = $form->getForm();

        return $formTask;
    }

    /**
     * @Route("/editTask/{taskId}/{categoryId}", name = "editTask")
     * @ParamConverter("task", class="CodersLabBundle:Tasks", options={"id" = "taskId"})
     * @Template()
     * @Method("GET")
     */
    public function editTaskAction(Tasks $task, $categoryId) {
        $action = $this->generateUrl('editTask', ['taskId' => $task->getId(), 'categoryId' => $categoryId]);
        $taskForm = $this->generateEditFormTask($task, $action);

        return ['taskEditForm' => $taskForm->createView()];
    }

    /**
     * @Route("/editTask/{taskId}/{categoryId}", name = "editTaskSave")
     * @ParamConverter("task", class="CodersLabBundle:Tasks", options={"id" = "taskId"})
     * @Method("POST")
     */
    public function editTaskSaveAction(Request $reg, $task, $categoryId) {
        $action = $this->generateUrl('editTask', ['taskId' => $task->getId(), 'categoryId' => $categoryId]);
        $taskForm = $this->generateEditFormTask($task, $action);
        $taskForm->handleRequest($reg);

        if ($taskForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        return $this->redirectToRoute('showCategory', ['categoryId' => $categoryId, 'which' => 3]);
    }

    /**
     * @Route("/markAsDoneTask/{taskId}/{categoryId}", name = "markAsDoneTask")
     * @ParamConverter("task", class="CodersLabBundle:Tasks", options={"id" = "taskId"})
     */
    public function markAsDoneTaskAction(Tasks $task, $categoryId) {
        $task->setStatus('Done');

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('showCategory', ['categoryId' => $categoryId, 'which' => 3]);
    }

    /**
     * @Route("/deleteTask/{taskId}/{categoryId}", name = "deleteTask")
     */
    public function deleteTaskAction($taskId, $categoryId) {
        $repoTask = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $task = $repoTask->find($taskId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('showCategory', ['categoryId' => $categoryId, 'which' => 3]);
    }

    /**
     * @Route("/showTask/{taskId}", name = "showTask")
     * @Template()
     */
    public function showTaskAction($taskId) {
        $repoTasks = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $task = $repoTasks->find($taskId);

        return ['task' => $task];
    }

    /**
     * @Route("/showAllTasks/{categoryId}/{which}", name ="showAllTasks")
     * @Template()
     */
    public function showAllTasksAction($categoryId) {
        $repoCategory = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $category = $repoCategory->find($categoryId);
        $repoTasks = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $tasks = $repoTasks->findByCategory($category);

        return ['tasks' => $tasks];
    }
}