<?php

namespace Matthewnw\Zoho\Reports;

	/**
		* PermissionInfo contains the permission details of views.
	*/

   	class PermissionInfo
   	{
		/**
			* @var string $view_name View name of the user.
		*/
      	public $view_name;
		/**
			* @var string $shared_by Contails the Shared by user mail-id.
		*/
      	public $shared_by;
		/**
			* @var array $filter_criteria Conatains Filter criterias..
		*/
      	public $filter_criteria = NULL;
		/**
			* @var array $perms_map Contains permissions list of views.
		*/
      	public $perms_map = array();

      	/**
         	* @internal Create PermissionInfo instance.
      	*/

      	function __construct($view_name, $shared_by)
      	{
         	$this->view_name = $view_name;
         	$this->shared_by = $shared_by;
      	}

      	/**
         	* @internal To set permissions.
      	*/

      	function setPermission($perm_name, $perm_value)
      	{
         	if($perm_value == 'true')
         	{
            	$perm_value = TRUE;
         	}
         	else
         	{
            	$perm_value = FALSE;
         	}
         	$this->perms_map[$perm_name] = $perm_value;
      	}

      	/**
         	* @internal To set filter criteria.
      	*/

      	function setFilterCriteria($filter_criteria)
      	{
         	$this->filter_criteria = $filter_criteria;
      	}

      	/**
         	* This method is used to get the name of the View that is shared.
         	* @return String A String value holds the name of the view.
      	*/

      	function getViewName()
      	{
         	return $this->view_name;
      	}

      	/**
         	* This method is used to get the email address of the user who shared the View.
         	* @return String A String value holds the email address of the user who shared the view.
      	*/

      	function getSharedBy()
      	{
         	return $this->shared_by;
      	}

      	/**
         	* This method is used to get the filter criteria associated to this PermissionInfo.
         	* @return String A String value holds the filter criteria.
      	*/

      	function getFilterCriteria()
      	{
         	return $this->filter_criteria;
      	}

      	/**
         	* This method is used to find whether this permission entry has READ permission.
         	* @return Boolean A Boolean value holds whether the READ operation is allowed or not.
      	*/

      	function hasReadPermission()
      	{
         	return $this->perms_map["read"];
      	}

      	/**
         	* This method is used to find whether this permission entry has EXPORT permission.
         	* @return Boolean A Boolean value holds whether EXPORT operation is allowed or not.
      	*/

      	function hasExportPermission()
      	{
         	return $this->perms_map["export"];
      	}

      	/**
         	* This method is used to find whether this permission entry has View Underlying Data permission.
         	* @return Boolean A Boolean value holds whether View Underlying Data operation is allowed or not.
      	*/

      	function hasVUDPermission()
      	{
         	return $this->perms_map["vud"];
      	}

      	/**
         	* This method is used to find whether this permission entry has ADDROW permission.
         	* @return Boolean A Boolean value holds whether the ADDROW operation is allowed or not.
      	*/

      	function hasAddRowPermission()
      	{
         	return $this->perms_map["addrow"];
      	}

      	/**
         	* This method is used to find whether this permission entry has UPDATEROW permission.
         	* @return Boolean A Boolean value holds whether the UPDATEROW operation is allowed or not.
      	*/

      	function hasUpdateRowPermission()
      	{
         	return $this->perms_map["updaterow"];
      	}

      	/**
         	* This method is used to find whether this permission entry has DELETEROW permission.
         	* @return Boolean A Boolean value holds whether the DELETEROW operation is allowed or not.
      	*/

      	function hasDeleteRowPermission()
      	{
         	return $this->perms_map["deleterow"];
      	}

      	/**
         	* This method is used to find whether this permission entry has DELETEALLROWS permission.
         	* @return Boolean A Boolean value holds whether the DELETE ALL ROWS operation is allowed or not.
      	*/

      	function hasDeleteAllRowsPermission()
      	{
         	return $this->perms_map["deleteallrows"];
      	}

      	/**
         	* This method is used to find whether this permission entry has APPENDIMPORT permission.
         	* @return Boolean A Boolean value holds whether the APPEND IMPORT operation is allowed or not.
      	*/

      	function hasAppendImportPermission()
      	{
         	return $this->perms_map["appendimport"];
      	}

      	/**
         	* This method is used to find whether this permission entry has UPDATEIMPORT permission.
         	* @return Boolean A Boolean value holds whether the UPDATE IMPORT operation is allowed or not.
      	*/

      	function hasUpdateImportPermission()
      	{
         	return $this->perms_map["updateimport"];
      	}

      	/**
         	* This method is used to find whether this permission entry has TRUNCATEIMPORT permission.
         	* @return Boolean A Boolean value holds whether the TRUNCATE IMPORT operation is allowed or not.
      	*/

      	function hasTruncateImportPermission()
      	{
         	return $this->perms_map["truncateimport"];
      	}

      	/**
         	* This method is used to find whether this permission entry has DELETEUPDATEADDIMPORT permission.
         	* @return Boolean A Boolean value holds whether the DELETEUPDATEADD IMPORT operation is allowed or not.
      	*/

      	function hasDeleteUpdateAddImportPermission()
      	{
         	return $this->perms_map["deleteupdateaddimport"];
      	}

      	/**
         	* This method is used to find whether this permission entry has SHARE permission.
         	* @return Boolean A Boolean value holds whether the SHARE permission operation is allowed or not.
      	*/

      	function hasSharePermission()
      	{
         	return $this->perms_map["share"];
      	}
   	}
