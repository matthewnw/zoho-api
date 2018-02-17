<?php

namespace Matthewnw\Zoho\Creator;

use Matthewnw\Zoho\Exception\APIError;

class Application {

    public $name;
    protected $zohoCreator;
    protected $views = array();

    public function __construct($name, Creator $zohoCreator) {
        $this->name = $name;
        $this->zohoCreator = $zohoCreator;
    }

	public function call($path, $params = array(), $options = array()) {
        return $this->zohoCreator->call("{$this->name}/$path", $params, $options);
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-view-records-in-view.html
     */
    public function viewRecords($viewName) {
        return $this->call("view/{$viewName}", array('raw' => 'true'));
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-list-forms-and-views.html
     */
    public function formsAndViews() {
        return $this->call("formsandviews");
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-add-records.html
     * @param array $data An associative array of key => value pairs to set
     */
    public function add($formName, $data) {
        $result = $this->call("{$formName}/add/", array(), array("PostData" => $data));
		if ($result instanceof APIError){

		}
        if ($result->formname[1]->operation[1]->values[1]->status[0] == 'Success') {
            return $result->formname[1]->operation[1]->values[0];
        } else {
            throw new \Exception(sprintf("Zoho error: %s", $result->formname[1]->operation[1]->values[1]->status[0]));
        }
    }

}
