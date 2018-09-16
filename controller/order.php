<?php

require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once 'model/orders.class.php';

class orderController {

    public static $defaultAction = "list";

    private $required = array('first_name', 'last_name', 'email');

    private $maxLengths = array (
        'id' => 10,
        'first_name' => 30,
        'last_name' => 30,
        'email' => 50,
        'price' => 10
    );

    private $validations = array (
        'id' => 'positivenumber',
        'first_name' => 'alfanum',
        'last_name' => 'alfanum',
        'email' => 'alfanum',
        'price' => 'positivenumber',
    );

    public function listAction() {
        $_SESSION['currMod'] = 'order';
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = orders::getOrdersListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        $paging->process($elementCount, routing::getPageId());

        $data = orders::getOrdersList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if(!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if(!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("order_list");
    }

    public function createAction()
    {
        $data = $this->validateInput();
        if ($data) {
            if (snowboards::insertOrder($data)) {
                routing::redirect(routing::getModule(), 'list');
            } else {
                $template = template::getInstance();
                $template->assign('fields', $_POST);
                $template->assign('formErrors', "Duplicate ID!");
                $this->showForm();
            }
        } else {
            $this->showForm();
        }
    }

    private function showForm()
    {
        $template = template::getInstance();
        $template->assign('required', $this->required);
        $template->assign('maxLengths', $this->maxLengths);
        $template->setView("order_form");
    }

    private function validateInput() {
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
}