<?php

namespace Matthewnw\Zoho\Reports;

	/**
		* ShareInfo contains the database shared details.
	*/

	class ShareInfo
   	{
		/**
			* @var array $group_members Group Members of the database.
		*/
      	private $group_members;
		/**
			* @var array $admin_members Database Owners of the database.
		*/
      	private $admin_members;
		/**
			* @var array $shared_user_perm_info The PermissionInfo list object for the shared user.
		*/
    	private $shared_user_perm_info;
		/**
			* @var array $group_perm_info The PermissionInfo list object for the groups.
		*/
      	private $group_perm_info;
		/**
			* @var array $public_perm_info The PermissionInfo list object for the public link.
		*/
      	private $public_perm_info;
		/**
			* @var array $private_link_perm_info The PermissionInfo list object for the private link.
		*/
      	private $private_link_perm_info;
		/**
			* @var const GROUPNAME It will indicate the groups.
		*/
      	const GROUPNAME = "groupName";

      	/**
        	* @internal Create ShareInfo class instance.
      	*/

      	function __construct($JSON_response)
      	{
         	$JSON_result = $JSON_response['response']['result'];
         	$user_info = $JSON_result['usershareinfo'];
         	$this->shared_user_perm_info = $this->getMailList($user_info, 'email');
         	$group_info = $JSON_result['groupshareinfo'];
         	$this->group_perm_info = $this->getMailList($group_info, 'groupName');
         	$public_info = $JSON_result['publicshareinfo'];
         	$this->public_perm_info = $this->getLinkList($public_info);
         	$private_info = $JSON_result['privatelinkshareinfo'];
         	$this->private_link_perm_info = $this->getLinkList($private_info);
         	$this->admin_members = $JSON_result['dbownershareinfo']['dbowners'];
      	}

      	/**
         	* @internal Get the permission list.
      	*/

      	function getMailList($info, $name)
      	{
      		$permissionlist = array();
         	$info_count = count($info);
         	for($i = 0 ; $i < $info_count ; $i++)
         	{
            	$JSON_new_info = $info[$i]['shareinfo'];
            	$user_list[$i] = $JSON_new_info[$name];
            	$tablecount[$i] = count($JSON_new_info['permissions']);
            	if($name == self::GROUPNAME)
            	{
               		$member_count[$i] = count($JSON_new_info['groupmembers']);
               		$grp_details = array();
                  	$grp_details['name'] = $user_list[$i];
                  	$grp_details['desc'] = $JSON_new_info['desc'];
               		if($member_count[$i] != 0)
               		{
                  		for($j = 0 ; $j < $member_count[$i] ; $j++)
                  		{
                  			$grp_details['members'][$j] = $JSON_new_info['groupmembers'][$j];
                  		}
                     	$this->group_members[$i] = $grp_details;
               		}
               		else
               		{
                  		$grp_details['members'] = array();
                     	$this->group_members[$i] = $grp_details;
               		}
            	}
            	for($j = 0 ; $j < $tablecount[$i] ; $j++)
            	{
               		$JSON_info = $JSON_new_info['permissions'][$j]['perminfo'];
               		$view_name = $JSON_info['viewname'];
               		$shared_by = $JSON_info['sharedby'];
               		$perm_info = new PermissionInfo($view_name, $shared_by);
               		$permission = $JSON_info['permission'];
               		foreach ($permission as $key => $value)
               		{
                  		$perm_info->setPermission($key, $value);
               		}
               		$permissionlist[$user_list[$i]][$j] = $perm_info;
            	}
        	}
        	return $permissionlist;
    	}

    	/**
    		* @internal Get the permission list.
    	*/

    	function getLinkList($info)
    	{
    		$permissionlist = array();
    		if(array_key_exists("email", $info))
    		{
	        	$email = $info['email'];
	        	$JSON_new_info = $info['permissions'];
	        	$tablecount = count($JSON_new_info);
	        	for($i = 0 ; $i < $tablecount ; $i++)
	        	{
	            	$JSON_info = $JSON_new_info[$i]['perminfo'];
	            	$view_name = $JSON_info['viewname'];
	            	$shared_by = $JSON_info['sharedby'];
	            	$perm_info = new PermissionInfo($view_name, $shared_by);
	            	$permission = $JSON_info['permission'];
	            	foreach ($permission as $key => $value)
	            	{
	               		$perm_info->setPermission($key, $value);
	            	}
	            	$permissionlist[$email][$i] = $perm_info;
	         	}
	         }
         	return $permissionlist;
      	}

      	/**
        	* This method is used to get the Shared Users of the specified database.
        	* @return array Shared Users of the database.
      	*/

      	function getSharedUsers()
      	{
         	return array_keys($this->shared_user_perm_info);
      	}

      	/**
         	* This method is used to get the Group Members of the specified database.
         	* @return array Group Members of the database.
      	*/

      	function getGroupMembers()
      	{
         	return $this->group_members;
      	}

      	/**
         	* This method is used to get the Database Owners of the specified database.
         	* @return array Database Owners of the database.
      	*/

      	function getDatabaseOwners()
      	{
         	return $this->admin_members;
      	}

      	/**
         	* This method is used to get the Permissions of the Shared Users.
         	* @return array-of-objects The PermissionInfo list for the Shared User.
      	*/

      	function getSharedUserPermissions()
      	{
         	return $this->shared_user_perm_info;
      	}

      	/**
         	* This method is used to get the Permissions of the Database Group.
         	* @return array-of-objects The PermissionInfo list for the Database Group.
      	*/

      	function getGroupPermissions()
      	{
         	return $this->group_perm_info;
      	}

      	/**
         	* This method is used to get the Permissions of the Private Link.
         	* @return array-of-objects The PermissionInfo list for the Private Link.
      	*/

      	function getPrivateLinkPermissions()
      	{
         	return $this->private_link_perm_info;
      	}

      	/**
         	* This method is used to get the Permissions of the Public Visitors.
         	* @return array-of-objects The PermissionInfo list for the Public Visitors.
      	*/

      	function getPublicPermissions()
      	{
         	return $this->public_perm_info;
      	}
   	}
