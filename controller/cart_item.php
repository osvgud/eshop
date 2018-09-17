<?php

require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once 'model/cart_items.class.php';
require_once 'model/orders.class.php';

class cart_itemController {

    public static $defaultAction = "list";

    private $required = array('fk_user', 'fk_snowboard');

    private $maxLengths = array (
    );

    private $validations = array (
        'id' => 'positivenumber',
        'fk_user' => 'alfanum',
        'fk_snowboard' => 'positivenumber'
    );

    public function listAction() {

        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = cart_items::getItemsListCount($_SESSION['username']);

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = cart_items::getItemsList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if(!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if(!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("cart_item_list");
    }

    public function createAction()
    {
        $id = routing::getId();
        // If entered data was valid
        if ($_SESSION['username'] != 'Svečias' && $_SESSION['username'] != '') {
            // Insert row into database
            $orderid = orders::getOrderByUser($_SESSION['username']);
            if($orderid) {
                if (cart_items::insertItem($_SESSION['username'], $id, $orderid)) {
                    // Redirect back to the list
                    routing::redirect($_SESSION['currMod'], 'list');
                } else {
                    // Overwrite fields array with submitted $_POST values
                    $template = template::getInstance();
                    $template->assign('fields', $_POST);
                    $template->assign('formErrors', "Duplicate ID!");
                    $this->showForm();
                }
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
        $template->setView("cart_item_form");
    }

    private function validateInput() {
        // Check if we even have any input
        if (empty($_POST['submit'])) {
            return false;
        }

        // Create Validator object
        $validator = new validator($this->validations,
            $this->required, $this->maxLengths);

        if(!$validator->validate($_POST)) {
            // Overwrite fields array with submitted $_POST values
            $template = template::getInstance();
            $template->assign('fields', $_POST);

            $formErrors = $validator->getErrorHTML();
            $template->assign('formErrors', $formErrors);
            return false;
        }

        // Prepare data array to be entered into SQL DB
        $data = $validator->preparePostFieldsForSQL();
        return $data;
    }

    public function deleteAction() {
        $id = routing::getId();

        $err = (cart_items::deleteItem($id)) ? '' : 'delete_error=1';

        // Redirect back to the list
        routing::redirect($_SESSION['currMod'], 'list', $err);
    }
}