<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @package module_admin_dashboard
 */
 
/**
 * This file handles any misc tasks that need to be done.
 * Loaded at the very end
 */

class Dashboard extends CodonModule
{
	function HTMLHead()
	{
		Template::Set('sidebar', 'sidebar_dashboard.tpl');
	}
	
	function Controller()
	{
		/*
		 * Check for updates
		 */
		switch($this->get->page)
		{
			default:

				/* Dashboard.tpl calls the functions below
				*/
				
				Template::Set('reportcounts', PIREPData::ShowReportCounts());
				Template::Show('dashboard.tpl');

                /*Template::Set('allpilots', PilotData::GetPendingPilots());
				Template::Show('pilots_pending.tpl');*/
				break;

			case 'about':

				Template::Show('core_about.tpl');

				break;
		}
	}

	function CheckInstallFolder()
	{
		if(file_exists(SITE_ROOT.'/install'))
		{
			Template::Set('message', 'The install folder still exists!! This poses a security risk. Please delete it immediately');
			Template::Show('core_error.tpl');
		}
	}

	/**
	 * Show the notification that an update is available
	 */
	function CheckForUpdates()
	{
		if(NOTIFY_UPDATE == true)
		{
			$postversion = @file_get_contents('http://www.phpvms.net/extern/version.php');
			$postversion = intval(str_replace('.', '', trim($postversion)));
			$currversion = intval(str_replace('.', '', PHPVMS_VERSION));
			
			if($currversion < $postversion)
			{
				Template::Set('message', 'An update for phpVMS is available! See the "Latest News" below');
				Template::Show('core_error.tpl');
				
				$updatenews = @file_get_contents('http://www.phpvms.net/extern/news.php');
				echo $updatenews;
			}
		}
	}
}
?>