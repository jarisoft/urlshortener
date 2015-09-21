<?php
namespace Jarisoft\Controller;

/**
 * This class handles the views, provides them with information and renders the output.
 *
 * @author jakob
 *        
 */
class ViewController extends Controller
{

    public function welcomeAction($data, $eventList)
    {
        $view = array(
            "welcome"
        );
        $this->renderView("Welcome", $view, $data, $eventList);
    }

    public function shortGeneratedAction($data, $eventList)
    {
        $view = array(
            "welcome",
            "successPage"
        );
        $this->renderView("Success", $view, $data, $eventList);
    }

    public function matchResultAction($data, $eventList)
    {
        $view = array(
            "welcome",
            "resultPage"
        );
        $this->renderView("Results", $view, $data, $eventList);
    }

    public function errorAction($data, $eventList)
    {
        $view = array(
            "errorPage",
            "welcome"
        );
        $this->renderView("Errors Occoured", $view, $data, $eventList);
    }

    private function renderView($title, $view, $data, $events)
    {
        $session = $this->getSession(true);
        $data['random_key'] = $session['random_key'];
        $data['title'] = $title;
        include 'src/Jarisoft/View/templates/header.php';
        foreach ($view as $page) {
            include 'src/Jarisoft/View/' . $page . '.php';
        }
        
        include 'src/Jarisoft/View/templates/footer.php';
    }
}