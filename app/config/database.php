<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development_local':
			require_once("database_local.php");	
		break;	
		
		case 'development':
			require_once("database_dev.php");
		break;
		
		case 'testing':
		case 'production':
			require_once("database_live.php");
		break;

		default:
			require_once("database_live.php");
	}
}