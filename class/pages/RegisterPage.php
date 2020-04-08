<?php

class RegisterPage {

    public $registerMessage;

    public function __construct( $pageVars)
    {
        $user = new UserController();

        if (isset($_POST['submit'])) {
            if ($user->register_user($_POST)) {
				header('location: http://localhost/mini-cms/dashboard/');
            } else {
                $this->registerMessage = 'Er is iets fout gegaan, probeer het opnieuw!';
            }
        }
    }

    

}

?>