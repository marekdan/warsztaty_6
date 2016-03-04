<?php

namespace CodersLabBundle\Controller;


use CodersLabBundle\Entity\Category;
use CodersLabBundle\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package CodersLabBundle\Controller
 * @Route("/category")
 */
class CategoryController extends Controller {

    public function generateFormCategory($category, $action) {
        $form = $this->createFormBuilder($category);
        $form->add('categoryName', 'text');
        $form->add('save', 'submit', ['label' => 'Submit']);
        $form->setAction($action);
        $categoryForm = $form->getForm();

        return $categoryForm;
    }

    /**
     * @Route("/addCategory/{userId}", name = "addCategory")
     * @Method("GET")
     * @Template()
     */
    public function addCategoryAction($userId) {
        $category = new Category();
        $action = $this->generateUrl('addCategory', ['userId' => $userId]);
        $categoryForm = $this->generateFormCategory($category, $action);

        return ['categoryForm' => $categoryForm->createView()];
    }

    /**
     * @Route("/addCategory/{userId}", name = "addCategorySave")
     * @Method("POST")
     */
    public function addCategorySaveAction(Request $reg, $userId) {
        $category = new Category();
        $action = $this->generateUrl('addCategory', ['userId' => $userId]);
        $categoryForm = $this->generateFormCategory($category, $action);
        $categoryForm->handleRequest($reg);

        if ($categoryForm->isSubmitted()) {
            $repoUser = $this->getDoctrine()->getRepository('CodersLabBundle:User');
            $user = $repoUser->find($userId);
            $category->setUsers($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->redirectToRoute('showMyCategories', ['userId' => $userId]);
    }

    /**
     * @Route("/editCategory/{categoryId}/{userId}", name = "editCategory")
     * @Method("GET")
     * @Template()
     */
    public function editCategoryAction($categoryId, $userId) {
        $repoCategory = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $category = $repoCategory->find($categoryId);
        $action = $this->generateUrl('editCategory', ['categoryId' => $categoryId, 'userId' => $userId]);
        $categoryForm = $this->generateFormCategory($category, $action);

        return ['categoryForm' => $categoryForm->createView()];
    }

    /**
     * @Route("/editCategory/{categoryId}/{userId}", name = "editCategorySave")
     * @Method("POST")
     */
    public function editCategorySaveAction(Request $reg, $categoryId, $userId) {
        $repoCategory = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $category = $repoCategory->find($categoryId);
        $action = $this->generateUrl('editCategory', ['categoryId' => $categoryId, 'userId' => $userId]);
        $categoryForm = $this->generateFormCategory($category, $action);
        $categoryForm->handleRequest($reg);

        if ($categoryForm->isSubmitted()) {
            $repoUser = $this->getDoctrine()->getRepository('CodersLabBundle:User');
            $user = $repoUser->find($userId);
            $category->setUsers($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->redirectToRoute('showMyCategories', ['userId' => $userId]);
    }

    /**
     * @Route("/deleteCategory/{categoryId}/{userId}", name = "deleteCategory")
     */
    public function deleteCategoryAction($categoryId, $userId) {
        $repoCategory = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $category = $repoCategory->find($categoryId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('showMyCategories', ['userId' => $userId]);
    }

    /**
     * @Route("/showMyCategories/{userId}", name = "showMyCategories")
     * @Template()
     */
    public function showMyCategoriesAction($userId) {
        $repoUser = $this->getDoctrine()->getRepository('CodersLabBundle:User');
        $user = $repoUser->find($userId);

        $repoCategories = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $categories = $repoCategories->findByUsers($user);

        return ['categories' => $categories];
    }

    /**
     * @Route("/showCategory/{categoryId}/{which}", name = "showCategory")
     * @Template()
     */
    public function showCategoryAction($categoryId, $which) {
        $repoCategory = $this->getDoctrine()->getRepository('CodersLabBundle:Category');
        $category = $repoCategory->find($categoryId);

        $repoTasks = $this->getDoctrine()->getRepository('CodersLabBundle:Tasks');
        $tasks = $repoTasks->findBy(
            array('category' => $category->getId()),
            array('priority' => 'ASC')
        );

        $sortTasks = [];
        if ($which == 1) {
            foreach ($tasks as $task) {
                if($task->getStatus() == 'To do')
                $sortTasks[] = $task;
            }
            $tasks = $sortTasks;
        }
        elseif ($which == 2) {
            foreach ($tasks as $task) {
                if($task->getStatus() == 'Done')
                    $sortTasks[] = $task;
            }
            $tasks = $sortTasks;
        }

        return ['category' => $category, 'tasks' => $tasks];
    }
}