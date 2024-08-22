<?php

namespace App\Controllers;

use App\Models\Users;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
	public function sendNotification($title , $description , $uid){
		log_message('debug', '***************** push Notification *****************');
		$users = new Users() ;
		$user_data = $users->getrow($uid) ;
		$header = [
			'Authorization: key=AAAAb19yTb8:APA91bF0M5F_yVfrzq82-VVkNe0eVTkyYRRRuVPBAR92_MK7gsvmOYZxX1Kcv_-2QkTIl-K_O-eNV5qgbX9Mvq3v-JbPl34Zm1XXdqkIyRh2FN2l2dfmxq5lehcAKNKMO2Dx1CJAv1ke',
			'Content-Type: application/json'
		];
		$tokens = unserialize($user_data['token']) ;
		if(gettype($tokens) == "string"){
			$ids = array($tokens) ;
			log_message('debug', '***************** Notification ids *****************'.var_export($ids , true) );
		}else{
			$ids = $tokens ;
		}
		// print_r($user_data['token']) ;
		// die ;
		$notification = [
			'title' => $title,
			'description' => $description
		];
		log_message('debug', '***************** push Notification *****************'.var_export($tokens , true) );

		$request = [
			'data' =>$notification,
			'registration_ids' =>$ids
		];
		$ch = curl_init();
		curl_setopt($ch , CURLOPT_URL , 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch , CURLOPT_POST , true);
		curl_setopt($ch , CURLOPT_HTTPHEADER , $header);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch , CURLOPT_POSTFIELDS , json_encode($request));

		$res = curl_exec($ch);
		curl_close($ch) ;
		log_message('debug', '***************** push Notification *****************'.$res);
		return 1 ;
	}
	public function alertnotification($ac ){
		log_message('debug', '***************** Alert push Notification *****************');
		$users = new Users() ;
		$user_data = $users->getrow(3) ;
		$header = [
			'Authorization: key=AAAAb19yTb8:APA91bF0M5F_yVfrzq82-VVkNe0eVTkyYRRRuVPBAR92_MK7gsvmOYZxX1Kcv_-2QkTIl-K_O-eNV5qgbX9Mvq3v-JbPl34Zm1XXdqkIyRh2FN2l2dfmxq5lehcAKNKMO2Dx1CJAv1ke',
			'Content-Type: application/json'
		];
		$tokens = unserialize($user_data['token']) ;
		if(gettype($tokens) == "string"){
			$ids = array($tokens) ;
			log_message('debug', '***************** Notification ids *****************'.var_export($ids , true) );
		}else{
			$ids = $tokens ;
		}
		$notification = [
			'title' => $ac,
			'description' => "You have a new ".$ac ,
		];
		log_message('debug', '***************** push Notification *****************'.var_export($tokens , true) );
		$request = [
			'data' =>$notification,
			'registration_ids' =>$ids
		];
		$ch = curl_init();
		curl_setopt($ch , CURLOPT_URL , 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch , CURLOPT_POST , true);
		curl_setopt($ch , CURLOPT_HTTPHEADER , $header);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch , CURLOPT_POSTFIELDS , json_encode($request));
		$res = curl_exec($ch);
		curl_close($ch) ;
		log_message('debug', '***************** push Notification *****************'.$res);
		// print_r($res) ;
		// die ;
		return 1 ;
	}
	public function statusNotification($title,$message , $id){
		log_message('debug', '***************** Status push Notification *****************');
		$users = new Users() ;
		$user_data = $users->getrow($id) ;
		$header = [
			'Authorization: key=AAAAb19yTb8:APA91bF0M5F_yVfrzq82-VVkNe0eVTkyYRRRuVPBAR92_MK7gsvmOYZxX1Kcv_-2QkTIl-K_O-eNV5qgbX9Mvq3v-JbPl34Zm1XXdqkIyRh2FN2l2dfmxq5lehcAKNKMO2Dx1CJAv1ke',
			'Content-Type: application/json'
		];
		$tokens = unserialize($user_data['token']) ;
		if(gettype($tokens) == "string"){
			$ids = array($tokens) ;
			log_message('debug', '***************** Notification ids *****************'.var_export($ids , true) );
		}else{
			$ids = $tokens ;
		}
		// print_r($user_data['token']) ;
		// die ;
		$notification = [
			'title' => $title,
			'description' => $message
		];
		log_message('debug', '***************** push Notification *****************'.var_export($tokens , true) );

		$request = [
			'data' =>$notification,
			'registration_ids' =>$ids
		];
		$ch = curl_init();
		curl_setopt($ch , CURLOPT_URL , 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch , CURLOPT_POST , true);
		curl_setopt($ch , CURLOPT_HTTPHEADER , $header);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch , CURLOPT_POSTFIELDS , json_encode($request));

		$res = curl_exec($ch);
		curl_close($ch) ;
		log_message('debug', '***************** push Notification *****************'.$res);
		return 1 ;
	}
	// public function sendwidthdrawNotification(){
	// 	log_message('debug', '***************** push Notification *****************');
	// 	$users = new Users() ;
	// 	$user_data = $users->getrow(3) ;
	// 	$header = [
	// 		'Authorization: key=AAAAb19yTb8:APA91bF0M5F_yVfrzq82-VVkNe0eVTkyYRRRuVPBAR92_MK7gsvmOYZxX1Kcv_-2QkTIl-K_O-eNV5qgbX9Mvq3v-JbPl34Zm1XXdqkIyRh2FN2l2dfmxq5lehcAKNKMO2Dx1CJAv1ke',
	// 		'Content-Type: application/json'
	// 	];
	// 	// log_message('debug', '***************** Tokens *****************'.$user_data['token'] );

	// 	$tokens = unserialize($user_data['token'])  ;
	// 	// log_message('debug', '***************** Token type *****************'.gettype($tokens) );
	// 	// log_message('debug', '***************** Token Var *****************'.$tokens );
	// 	// die ;
	// 	if(gettype($tokens) == "string"){
	// 		$ids = array($tokens) ;
	// 	}else{
	// 		$ids = $tokens ;
	// 	}
		
	// 	// $ids = ['dbKzrdjLY9Yqxl26RqfpGl:APA91bHzS10PmekJ88XM4WFG6OiT9q1UbPPWQZmwAoLG3olw8c9DEPTBLHtQ0D0tkmXuMrTKuUohCiq6Lvgkkm9pTLAG5bGzE7ZjRvQvAM_UVfJuxkxa2R3KfnAZCizm2c1ZDjUvyiWY'] ;
    //     // $ids = ['dAQ2iLQeBXlVALKxtp_h64:APA91bFNl9v5EEEFzvxyho0WDAv-FMlgXi-hp5-kwokv-Bf7ZMleN4H8zClyUqSsxMsczzMR73F49xmYkXW4KRNwQ0XIleKJkUVfe5dErYoLxmWdhtTyNw-60M29hvpW50W3TOu0eWXV' ] ;
	// 	log_message('debug', '***************** Notification ids *****************'.var_export($ids , true) );
	// 	$notification = [
	// 		'title' => "Withdraw" ,
	// 		'body' => "Recieve New Widthdraw request from \n ".ucfirst($_SESSION['user_data']['firstName']). " " .ucfirst($_SESSION['user_data']['lastName']),
	// 	];
	// 	// log_message('debug', '***************** push Notification *****************'.var_export($tokens , true) );
	// 	$request = [
	// 		'notification' => $notification,
	// 		'registration_ids' => $ids ,
	// 	];
	// 	$withdraw = curl_init();
	// 	curl_setopt($withdraw , CURLOPT_URL , 'https://fcm.googleapis.com/fcm/send');
	// 	curl_setopt($withdraw , CURLOPT_POST , true);
	// 	curl_setopt($withdraw , CURLOPT_HTTPHEADER , $header);
	// 	curl_setopt($withdraw , CURLOPT_RETURNTRANSFER , true);
	// 	curl_setopt($withdraw , CURLOPT_SSL_VERIFYPEER , false);
	// 	curl_setopt($withdraw , CURLOPT_POSTFIELDS , json_encode($request));

	// 	$res = curl_exec($withdraw);
	// 	curl_close($withdraw) ;
	// 	log_message('debug', '***************** Notification Result *****************'.$res);
	// 	// print_r($res) ;
	// 	// die ;
	// 	return 1 ;
	// }
	// public function senddepositNotification(){
	// 	log_message('debug', '***************** push Notification *****************');
	// 	$users = new Users() ;
	// 	$user_data = $users->getrow(3) ;
	// 	$header = [
	// 		'Authorization: key=AAAAb19yTb8:APA91bF0M5F_yVfrzq82-VVkNe0eVTkyYRRRuVPBAR92_MK7gsvmOYZxX1Kcv_-2QkTIl-K_O-eNV5qgbX9Mvq3v-JbPl34Zm1XXdqkIyRh2FN2l2dfmxq5lehcAKNKMO2Dx1CJAv1ke',
	// 		'Content-Type: application/json'
	// 	];
	// 	// log_message('debug', '***************** Tokens *****************'.$user_data['token'] );

	// 	$tokens = unserialize($user_data['token'])  ;
	// 	// log_message('debug', '***************** Token type *****************'.gettype($tokens) );
	// 	// log_message('debug', '***************** Token Var *****************'.$tokens );
	// 	// die ;
	// 	if(gettype($tokens) == "string"){
	// 		$ids = array($tokens) ;
	// 	}else{
	// 		$ids = $tokens ;
	// 	}
		
	// 	// $ids = ['dbKzrdjLY9Yqxl26RqfpGl:APA91bHzS10PmekJ88XM4WFG6OiT9q1UbPPWQZmwAoLG3olw8c9DEPTBLHtQ0D0tkmXuMrTKuUohCiq6Lvgkkm9pTLAG5bGzE7ZjRvQvAM_UVfJuxkxa2R3KfnAZCizm2c1ZDjUvyiWY'] ;
    //     // $ids = ['dAQ2iLQeBXlVALKxtp_h64:APA91bFNl9v5EEEFzvxyho0WDAv-FMlgXi-hp5-kwokv-Bf7ZMleN4H8zClyUqSsxMsczzMR73F49xmYkXW4KRNwQ0XIleKJkUVfe5dErYoLxmWdhtTyNw-60M29hvpW50W3TOu0eWXV' ] ;
	// 	log_message('debug', '***************** Notification ids *****************'.var_export($ids , true) );
	// 	$notification = [
	// 		'title' => "Deposit" ,
	// 		'body' => "Recieve New Deposit request from \n ".ucfirst($_SESSION['user_data']['firstName']). " " .ucfirst($_SESSION['user_data']['lastName']),
	// 	];
	// 	// log_message('debug', '***************** push Notification *****************'.var_export($tokens , true) );
	// 	$request = [
	// 		'notification' => $notification,
	// 		'registration_ids' => $ids ,
	// 	];
	// 	$deposit = curl_init();
	// 	curl_setopt($deposit , CURLOPT_URL , 'https://fcm.googleapis.com/fcm/send');
	// 	curl_setopt($deposit , CURLOPT_POST , true);
	// 	curl_setopt($deposit , CURLOPT_HTTPHEADER , $header);
	// 	curl_setopt($deposit , CURLOPT_RETURNTRANSFER , true);
	// 	curl_setopt($deposit , CURLOPT_SSL_VERIFYPEER , false);
	// 	curl_setopt($deposit , CURLOPT_POSTFIELDS , json_encode($request));

	// 	$res = curl_exec($deposit);
	// 	curl_close($deposit) ;
	// 	log_message('debug', '***************** Notification Result *****************'.$res);
	// 	// print_r($res) ;
	// 	// die ;
	// 	return 1 ;
	// }
}
