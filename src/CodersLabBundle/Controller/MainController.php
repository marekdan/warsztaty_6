<?php

namespace CodersLabBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller {

    /**
     * @Route("/", name = "mainSite")
     * @Template()
     */
    public function MainSiteAction(){

        return [];
    }
}

?>

<!---
- zaimplementuj funkcjonalność edycji kategorii tematycznych
- zaimplementuj funkcjonalność edycji zadań
- zaimplementuj funkcjonalność wyświetlenia listy zadań użytkownika, z rozróżnieniem na
zadania aktualnie i już wykonane (opcja: wyświetl kalendarz pokazujący ilość zadań każdego
dnia)

- zaimplementuj funkcjonalność dodawania komentarzy
- zaimplementuj funkcjonalność wyświetlenia ilości komentarzy przy każdym z zadań na liście
- zaimplementuj funkcjonalność uniemożliwiającą edycję zakończonych zadań-->