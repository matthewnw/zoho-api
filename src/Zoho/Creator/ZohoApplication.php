<?php

namespace Matthewnw\Zoho\Creator;

use Matthewnw\Zoho\Exception\ZohoAPIError;

class ZohoApplication {

    public $name;

    protected $zohoCreator;

    public $views = [];

    public $forms = [];

    public function __construct($name, ZohoCreatorClient $zohoCreator) {
        $this->name = $name;
        $this->zohoCreator = $zohoCreator;
    }

	public function call($path, $params = array(), $username = null) {
        return $this->zohoCreator->call("{$this->name}/$path", $params, $username);
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-view-records-in-view.html
     */
    public function getRecords($viewName) {
        return $this->call("view/{$viewName}", array('raw' => 'true'));
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-list-forms-and-views.html
     */
    public function getFormsAndViews() {
        $response = $this->call("formsandviews");
        if (! $response instanceOf ZohoAPIError){
            $this->forms = $response['application-name'][1]['formList'];
            $this->views = $response['application-name'][1]['viewList'];
        }
        return $response;
    }

	/**
     * @see https://www.zoho.eu/creator/help/api/rest-api/rest-api-add-records.html
     * @param array $data An associative array of key => value pairs to set
     */
    public function add($formName, $data) {
        $response = $this->call("form/{$formName}/record/add/", $data, $this->zohoCreator->username);
        if (isset($response['formname'][1]['operation'][1]['status'])) {
            if ($response['formname'][1]['operation'][1]['status'] == 'Success'){
                return $response['formname'][1]['operation'][1]['values'];
            }else{
                return $response['formname'][1]['operation'][1]['status'];
            }
        }
        throw new \Exception(sprintf("Zoho error: %s", $response));
    }

}
