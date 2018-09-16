<?php
require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once 'model/users.class.php';
require_once  'model/snowboards.class.php';

class userController {

    public static $defaultAction = "create";

    // nustatome privalomus laukus
    private $required = array('username', 'password', 'password2');

    // maksimalūs leidžiami laukų ilgiai
    private $maxLengths = array (
        'username' => 32,
        'password' => 32,
        'password2' => 32
    );

    // nustatome laukų validatorių tipus
    private $validations = array (
        'username' => 'alfanum',
        'password' => 'alfanum',
        'password2' => 'alfanum'
    );

    private function validateInput() {
        // Check if we even have any input
        if (empty($_POST['submit'])) {
            return false;
        }

        $validator = new validator($this->validations,
            $this->required, $this->maxLengths);

        if(!$validator->validate($_POST)) {
            $template = template::getInstance();
            $template->assign('fields', $_POST);

            $formErrors = $validator->getErrorHTML();
            $template->assign('formErrors', $formErrors);
            return false;
        }

        $data = $validator->preparePostFieldsForSQL();
        return $data;
    }

    private function showForm($form) {
        $template = template::getInstance();
        $template->assign('required', $this->required);
        $template->assign('maxLengths', $this->maxLengths);
        $template->setView($form);
    }
    public function createAction() {
        $data = $this->validateInput();
        if ($data) {
            if (users::insertUser($data)) {
                routing::redirect(routing::getModule(), 'list');
            } else {
                $template = template::getInstance();
                $template->assign('fields', $_POST);
                $template->assign('formErrors', "Nesutampa slaptažodžiai");
                $this->showForm("register");
            }
        } else {
            $this->showForm("register");
        }
    }
    public function listAction() {
        header('location: index.php');
    }
};
