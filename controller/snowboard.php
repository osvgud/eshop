<?php

require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once 'model/snowboards.class.php';

class snowboardController
{

    public static $defaultAction = "list";

    private $required = array('name', 'price');

    private $maxLengths = array(
        'id' => 10,
        'name' => 100,
        'price' => 8,
        'description' => 10000,
        'warranty' => 2
    );

    private $validations = array(
        'id' => 'positivenumber',
        'name' => 'alfanum',
        'price' => 'positivenumber',
        'description' => 'alfanum',
        'warranty' => 'positivenumber'
    );

    public function listAction()
    {
        $_SESSION['currMod'] = 'snowboard';
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = snowboards::getSnowboardsListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = snowboards::getSnowboardsList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if (!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if (!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("snowboard_list");
    }

    public function createAction()
    {
        $data = $this->validateInput();
        if ($data) {
            if (snowboards::insertSnowboard($data)) {
                routing::redirect(routing::getModule(), 'list');
            } else {
                // Overwrite fields array with submitted $_POST values
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
        $template->setView("snowboard_form");
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

    public function editAction() {
        $id = routing::getId();

        $snowboard = snowboards::getSnowboard($id);
        if ($snowboard == false) {
            routing::redirect(routing::getModule(), 'list', 'id_error=1');
            return;
        }

        $template = template::getInstance();
        $template->assign('fields', $snowboard);

        $data = $this->validateInput();
        if ($data) {
            $data['id'] = $id;

            snowboards::updateSnowboard($data);

            routing::redirect(routing::getModule(), 'list');
        } else {
            $this->showForm();
        }
    }

    public function viewAction()
    {
        $id = routing::getId();

        $data = snowboards::getSnowboard($id);

        $template = template::getInstance();

        $template->assign('data', $data);

        $template->setView("snowboard_view");
    }

    public function deleteAction() {
        $id = routing::getId();

        $err = (snowboards::deleteSnowboard($id)) ? '' : 'delete_error=1';

        routing::redirect(routing::getModule(), 'list', $err);
    }


}