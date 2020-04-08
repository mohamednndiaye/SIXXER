<?php

class LoginPage {

    public $loginMessage;

    public function __construct( $pageVars)
    {
        $user = new UserController();

        if (isset($_POST['submit'])) {
            if ($user->login_user($_POST)) {
				header('location: http://localhost/mini-cms/dashboard/');
            } else {
                $this->loginMessage = 'Er is iets fout gegaan, probeer het opnieuw!';
            }
        }
    }

    

}

?>