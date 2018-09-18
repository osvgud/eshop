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
        $paging = new paging(25);

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

    public function sortAction()
    {
        $_SESSION['currMod'] = 'order';
        $orderby = routing::getId();
        if($orderby) {
            if ($orderby == $_SESSION['orderby'] and $_SESSION['fromto'] == 'ASC') {
                $_SESSION['fromto'] = 'DESC';
            } elseif ($orderby == $_SESSION['orderby'] and $_SESSION['fromto'] == 'DESC') {
                $_SESSION['fromto'] = 'ASC';
            } else {
                $_SESSION['fromto'] = 'ASC';
            }
            $_SESSION['orderby'] = $orderby;
        }
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = orders::getOrdersListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(25);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = orders::getOrdersListOrder($paging->size, $paging->first, $orderby);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if (!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if (!empty($_GET['id_error']))
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

    public function editAction() {
        $id = orders::getOrderByUser($_SESSION['username']);

        $order = orders::getOrder($id);
        if ($order == false) {
            routing::redirect(routing::getModule(), 'list', 'id_error=1');
            return;
        }

        $template = template::getInstance();
        $template->assign('fields', $order);

        $data = $this->validateInput();
        if ($data) {
            $data['id'] = $id;

            orders::updateOrder($data);
            orders::createOrderForUser();
            routing::redirect(routing::getModule(), 'list');
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