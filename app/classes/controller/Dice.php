<?php

namespace App\Controller;

class Dice extends Base {

    /** @var \App\Objects\Form\Login */
    protected $form;

    public function __construct() {
        parent::__construct();
        $this->form = new \App\Objects\Form\Dice();


        $view = new \Core\Page\View([
            'title' => 'Mesk kailiuką'
        ]);

        $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');


        switch ($this->form->process()) {
            case \App\Objects\Form\Dice::STATUS_SUCCESS:
                if ($this->bet()) {
                    $this->page['content'] = 'Tu laimejai!';
                } else {
                    $this->page['content'] = 'Bandyk dar kartą!';
                }
                break;
            default:
                $this->page['content'] .= $this->form->render();
        }
    }

    private function bet() {
        $user = \App\App::$session->getUser()->getEmail();
        $repo = new \App\User\Repository(\App\App::$db_conn);
        $email = $repo->load(\App\App::$session->getUser()->getEmail());
        $balance = $email->getBalance();
        $safe_input = $this->form->getInput();
        $bet = $safe_input['bet'];
        $balance -= $bet;
        $success = false;
        if (rand(0, 5) == 2) {
            $success = true;
            $balance += $bet * 2.5;
        }
        $email->setBalance($balance);

        return $success;
    }

}
