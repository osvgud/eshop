<?php
require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once  'model/users.class.php';

class loginController {
    public static $defaultAction = "create";

    // nustatome privalomus laukus
    private $required = array('username', 'password');

    // maksimalūs leidžiami laukų ilgiai
    private $maxLengths = array (
        'username' => 32,
        'password' => 32
    );

    // nustatome laukų validatorių tipus
    private $validations = array (
        'username' => 'alfanum',
        'password' => 'alfanum'
    );

    private function validateInput() {
        // Patikriname ar įvesti duomenys
        if (empty($_POST['submit'])) {
            return false;
        }

        // Sukuriame validacijos objektą
        $validator = new validator($this->validations,
            $this->required, $this->maxLengths);

        if(!$validator->validate($_POST)) {
            // Perrašome laukų masyvą su priimtomis $_POST reikšmėmis
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
        // If entered data was valid
        if ($data) {
            // Insert row into database
            if (users::checkUser($data)) {
                // Redirect back to the list
                $_SESSION['kreps_count'] = 5;
                routing::redirect(routing::getModule(), 'list');
            } else {
                // Overwrite fields array with submitted $_POST values
                $template = template::getInstance();
                $template->assign('fields', $_POST);
                $template->assign('formErrors', "Blogas slapyvardis arba slaptažodis");
                $this->showForm("login");
            }
        } else {
            $this->showForm("login");
        }
    }

    public function listAction() {
        header('location: /nfq/index.php?module=snowboard');
    }
}