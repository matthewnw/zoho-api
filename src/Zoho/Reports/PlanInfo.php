<?php

namespace Matthewnw\Zoho\Reports;

	/**
		* PlanInfo contains the plan details.
	*/

	class PlanInfo
	{
		/**
			* @var string $plan The type of the user plan.
		*/
		private $plan;
		/**
			* @var string $addons The addon details.
		*/
		private $addons;
		/**
			* @var string $billing_date The billing date.
		*/
		private $billing_date;
		/**
			* @var long $rows_allowed The total row allowed to the user.
		*/
		private $rows_allowed;
		/**
			* @var long $rows_used The number of rows used by the user.
		*/
		private $rows_used;
		/**
			* @var string $trial_availed Used to identify the trial pack.
		*/
		private $trial_availed;
		/**
			* @var string $trial_plan The trial plan detail.
		*/
		private $trial_plan;
		/**
			* @var boolean $trial_status The trial pack status.
		*/
		private $trial_status;
		/**
			* @var string $trial_end_date The end date of the trial pack.
		*/
		private $trial_end_date;

		/**
			* @internal Creates a new PlanInfo instance.
		*/

		function __construct($JSON_result)
		{
			$JSON_result = $JSON_result['response']['result'];
			$this->plan = $JSON_result['plan'];
			$this->addons = $JSON_result['addon'];
			$this->billing_date = $JSON_result['billingDate'];
			$this->rows_allowed = $JSON_result['rowsAllowed'];
			$this->rows_used = $JSON_result['rowsUsed'];
			$this->trial_availed = $JSON_result['TrialAvailed'];
			if($this->trial_availed != "false")
			{
				$this->trial_plan = $JSON_result['TrialPlan'];
				$this->trial_status = $JSON_result['TrialStatus'];
				$this->trial_end_date = $JSON_result['TrialEndDate'];
			}
		}

		/**
			* Get the type of the user plan.
			* @return string $plan The type of the user plan.
		*/

		function getPlan()
		{
			return $this->plan;
		}

		/**
			* Get all the addons of the account.
			* @return string $addons The addon details.
		*/

		function getAddons()
		{
			return $this->addons;
		}

		/**
			* Get the billing date of the plan.
			* @return string $billing_date The billing date.
		*/

		function getBillingDate()
		{
			return $this->billing_date;
		}

		/**
			* Get the total row allowed to the user.
			* @return long The total row allowed to the user.
		*/

		function getRowsAllowed()
		{
			return $this->rows_allowed;
		}

		/**
			* Get the number of rows that were used by the user.
			* @return long The number of rows used by the user.
		*/

		function getRowsUsed()
		{
			return $this->rows_used;
		}

		/**
			* This method is Used to identify the trial pack.
			* @return boolean $trial_availed Used to identify the trial pack.
		*/

		function isTrialAvailed()
		{
			return $this->trial_availed;
		}

		/**
			* Get the trial plan detail.
			* @return string  The trial plan detail.
		*/

		function getTrialPlan()
		{
			return $this->trial_plan;
		}

		/**
			* Get the trial pack status.
			* @return boolean The trial pack status.
		*/

		function getTrialStatus()
		{
			if($this->trial_status == 'true')
         	{
            	$this->trial_status = TRUE;
         	}
         	else
         	{
            	$this->trial_status = FALSE;
         	}
			return $this->trial_status;
		}

		/**
			* Get the end date of the trial pack.
			* @return string The end date of the trial pack.
		*/

		function getTrialEndDate()
		{
			return $this->trial_end_date;
		}
	}
