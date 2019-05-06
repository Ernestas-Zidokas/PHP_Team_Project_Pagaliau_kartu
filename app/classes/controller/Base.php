<?php

namespace App\Controller;

class Base extends \Core\Page\Controller {

    public function __construct() {
        parent::__construct();

        $this->page['stylesheets'][] = 'css/style.css';

        if (!\App\App::$session->isLoggedIn() === true) {
            $nav_view = new \App\View\Navigation([
                [
                    'link' => 'register',
                    'title' => 'Register'
                ],
                [
                    'link' => 'login',
                    'title' => 'Login'
                ]
            ]);
        } else {
            $nav_view = new \App\View\Navigation([
                [
                    'link' => 'cash-in',
                    'title' => 'Cash-in'
                ],
                [
                    'link' => 'dice',
                    'title' => 'Play'
                ],
                [
                    'link' => 'logout',
                    'title' => 'Logout'
                ]
            ]);
        }
        $this->page['header'] = $nav_view->render();
    }

}
