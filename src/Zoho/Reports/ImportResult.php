<?php

namespace Matthewnw\Zoho\Reports;

	/**
		* ImportResult contains the result of an import operation.
	*/

	class ImportResult
	{
		/**
			* @var string $import_type The type of the import operation.
		*/
		private $import_type;
		/**
			* @var int $total_column_count The total columns that were present in the imported file.
		*/
		private $total_column_count;
		/**
			* @var int $selected_column_count The number of columns that were imported.See ZOHO_SELECTED_COLUMNS parameter.
		*/
		private $selected_column_count;
		/**
			* @var long $total_row_count The total row count in the imported file.
		*/
		private $total_row_count;
		/**
			* @var long $success_row_count The number of rows that were imported successfully without errors.
		*/
		private $success_row_count;
		/**
			* @var string $warnings The number of rows that were imported with warnings.
		*/
		private $warnings;
		/**
			* @var string $import_operation The type of import operation.
		*/
		private $import_operation;
		/**
			* @var string $import_errors The first 100 import errors.
		*/
		private $import_errors;
		/**
			* @var string $column_details The column names of the imported columns.
		*/
		private $column_details;

		/**
			* @internal Creates a new Import_Result instance.
		*/

		function __construct($JSON_result)
		{
			$JSON_importsummary = $JSON_result['response']['result']['importSummary'];
			$this->import_type = $JSON_importsummary['importType'];
			$this->total_column_count = $JSON_importsummary['totalColumnCount'];
			$this->selected_column_count = $JSON_importsummary['selectedColumnCount'];
			$this->total_row_count = $JSON_importsummary['totalRowCount'];
			$this->success_row_count = $JSON_importsummary['successRowCount'];
			$this->warnings = $JSON_importsummary['warnings'];
			$this->import_operation = $JSON_importsummary['importOperation'];
			$this->import_errors = $JSON_result['response']['result']['importErrors'];
			$this->column_details = $JSON_result['response']['result']['columnDetails'];
		}

		/**
			* Get the type of the import operation.
			* @return string The type of the import operation.
		*/

		function getImportType()
		{
			return $this->import_type;
		}

		/**
			* Get the total columns that were present in the imported file.
			* @return integer The total columns that were present in the imported file.
		*/

		function getTotalColumnCount()
		{
			return $this->total_column_count;
		}

		/**
			* Get the number of columns that were imported.See ZOHO_SELECTED_COLUMNS parameter.
			* @return integer The number of columns that were imported.
		*/

		function getSelectedColumnCount()
		{
			return $this->selected_column_count;
		}

		/**
			* Get the total row count in the imported file.
			* @return long The total row count in the imported file.
		*/

		function getTotalRowCount()
		{
			return $this->total_row_count;
		}

		/**
			* Get the number of rows that were imported successfully without errors.
			* @return long The number of rows that were imported successfully without errors.
		*/

		function getSuccessRowCount()
		{
			return $this->success_row_count;
		}

		/**
			* Get the number of rows that were imported with warnings. Applicable if ZOHO_ON_IMPORT_ERROR parameter has been set to SETCOLUMNEMPTY.
			* @return long The number of rows that were imported with warnings.
		*/

		function getRowWithWarningCount()
		{
			return $this->warnings;
		}

		/**
			* Get the type of import operation. Can be either.
			* created --> if the specified table has been created. For this ZOHO_CREATE_TABLE parameter should have been set to true or updated --> if the specified table already exists.
			* @return string The type of import operation.
		*/

		function getImportOperation()
		{
			return $this->import_operation;
		}

		/**
			* Get the first 100 import errors. Applicable if ZOHO_ON_IMPORT_ERROR parameter is either SKIPROW or SETCOLUMNEMPTY. In case of ABORT , ServerException is thrown.
			* @return string The first 100 import errors.
		*/

		function getImportErrors()
		{
			return $this->import_errors;
		}

		/**
			* Get the column names of the imported columns.
			* @return string The imported column names.
		*/

		function getImportedColumns()
		{
			return $this->column_details;
		}

		/**
			* Get the data type of the specified column.
			* @param string $column_name Name of the column.
			* @return string The column datatype.
		*/

		function getColumnDataType($column_name)
		{
			return $this->column_details[$column_name];
		}

		/**
			* Get the complete response content as sent by the server.
			* @return string The complete response content.
		*/

		function toString()
		{
			$str1 = "importtype  $this->import_type totalcolumncount $this->total_column_count";
			$str2 = "selectedcolumncount $this->selected_column_count totalrowcount $this->total_row_count";
			$str3 = "successrowcount $this->success_row_count rowwithwarningcount $this->warnings importoperation $this->import_operation";
			return "Import result: ".$str1." ".$str2." ".$str3;
		}
	}
