<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development_local':
			require_once("config_local.php");	
		break;	
		
		case 'development':
			require_once("config_dev.php");
		break;
		
		case 'testing':
		case 'production':
			require_once("config_live.php");
		break;

		default:
			require_once("config_live.php");
	}
}

