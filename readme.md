# Zoho API Wrapper

Library offers API wrapper for Zoho Creator and Zoho Reports [https://www.zoho.com](https://www.zoho.com).

PSR-4 compatible

## Features

- Access Creator applications and get/add/delete records
- Access Reports and import/export data

## Installation

The preferred way to install the library is using composer.

Run:

    composer require matthewnw/zoho-api

## Examples

### Creator Example

    use Mattnw\Zoho\Creator\ZohoCreatorClient;

    // Initializes the class.
    $zohoCreatorClient = new ZohoCreatorClient($apiToken);

    // Get a list of available Applications
    $creatorapplications = $zohoCreatorClient->applications();

    // Get a specific Application instance
    $creatorapplication = $zohoCreatorClient->application($applicationName);

    // get records from a Creator View and chain application method
    $creatorViewRecords = $zohoCreatorClient->application($applicationName)->viewRecords($viewName);

    // add records form a Creator Form
    $creatorapplication->add($formName, $dataArray);

### Reports Example

    $zohoReportsClient = new ZohoReportsClient($apiToken);

    // https://zohoreportsapi.wiki.zoho.com/importing-bulk-data.html
    $uri = $zohoReportsClient->getURI($emailId, $reportsDatabaseName, $reportsTableName);
    $importType = 'TRUNCATEADD'; // APPEND, TRUNCATEADD, UPDATEADD
    $autoIdentify = 'TRUE';
    $onError = 'ABORT';
    $importData = json_encode($report_leads);
    $config = ['ZOHO_IMPORT_FILETYPE' => 'JSON'];

    $importReports = $zohoReportsClient->importDataAsString($uri, $importType, $importData, $autoIdentify, $onError, $config);

## Zoho API Documentation

### Reports API

https://zohoreportsapi.wiki.zoho.com/

### ReportClient.php API Guide

https://www.zoho.com/reports/api/?php#zoho-reports-api

### Creator API

https://www.zoho.eu/creator/help/api/

## Author

Matthew Williams matthew@codelaunch.uk
