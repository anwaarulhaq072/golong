<?php

namespace App\Controllers;

// require './vendor/autoload.php';

use Twilio\Rest\Client;

use App\Models\Users;
use App\Models\LoginAttempt;
use App\Models\Alerts;
use App\Models\AlertStatus;

use App\Libraries\Emails;
use App\Libraries\permissions;
use App\Models\Singlenotification;

class Home extends BaseController
{

	public function index()
	{
		session_start();
		if (isset($_SESSION['email'])) {
			if ($_SESSION['user_data']['userTypeId'] == 2) {
				return redirect()->to('/user/dashboard');
			} else if ($_SESSION['user_data']['userTypeId'] == 1) {
				return redirect()->to('/admin/dashboard');
			} else if ($_SESSION['user_data']['userTypeId'] == 4) {
				return redirect()->to('/user/accountantDashboard');
			}
		}
		return view('/home/signin-signup');
	}
	public function otpVerify()
	{

		session_start();
		$users = new Users();
		$user_info = $users->getrow($_POST['userid']);
		// log_message('debug', '***************** USerDATA1 *****************' . var_export($user_info, true));
		// log_message('debug', '***************** USerDATA1 *****************' . var_export($GLOBALS['email'], true));
		// log_message('debug', '***************** USerDATA *****************' . var_export($_SESSION['user_data'], true));
		$wrong_data = array(
			'status' => 'false',
			'message' => 'Incorrect Code*'
		);
		$form_code = $_POST['code'];
		// $_SESSION['OTP'] = $form_code;
		// log_message('debug',"Email: ".$form_email." Password: ".$form_password);


		if ($form_code == $user_info['otp']) {
			$_SESSION['email'] = $user_info['email'];
			$_SESSION['user_data'] = $user_info;
			$users->update($_POST['userid'], [
				'sessionid' => session_id(),
			]);
			return json_encode(base_url());
		} else {
			// Incorrect username or password
			log_message('debug', 'User enters wrong OTP: ' . $form_code);
			return json_encode($wrong_data);
		}
	}

	public function logout()
	{
		session_start();
		session_destroy();
		return view('/home/logout');
	}
	public function superadminlogin()
	{
		session_start();
		session_destroy();
		return view('/home/loginSuperAdmin');
	}
	public function forgetPassword()
	{
		return view('/home/recover-password');
	}
	public function confirmation()
	{
		return view('/home/confirm-mail');
	}
	public function profile()
	{
		session_start();
		$users = new Users();
		$singleNotification = new Singlenotification();
		$id = $_SESSION['user_data']['id'];
		$alert_status = new AlertStatus();
		$data['profileInfo'] = $users->getrow($id);
		if ($_SESSION['user_data']['userTypeId'] == 1) {
			$data['notification'] = $alert_status->getCurrentAlertNotificationById($id);
		} else {
			$data['notification'] = $singleNotification->getCurrentDataNotificationsByUserId($id);
		}
		return view('/home/profile', $data);
	}
	public function updateProfile()
	{

		$users = new Users();
		session_start();
		if ($_POST['id'] == $_SESSION['user_data']['id']) {
			$users->update($_POST['id'], [
				'firstName' => $_POST['firstName'],
				'lastName' => $_POST['lastName'],
				'phone' => $_POST['phone'],
				'bio' => $_POST['bio'],
			]);

			$id = $_SESSION['user_data']['id'];
			$ext = pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION);
			$target_dir = "assets/images/users/";
			if ($_SESSION['user_data']['profile_img']) {
				if (file_exists($_SESSION['user_data']['profile_img'])) {
					unlink($_SESSION['user_data']['profile_img']);
				}
			}
			$target_dir = $target_dir . 'user_id-' . $id . '.' . $ext;
			if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_dir)) {
				// echo $id.' ................ '.$target_dir;
				$users->update($id, [
					'profile_img' => '/' . $target_dir
				]);
				$_SESSION['user_data']['profile_img'] = '/' . $target_dir;
			} else {
				// echo "Sorry, there was an error uploading your file.";
			}
			if (isset($users)) {
				$_SESSION['success'] = 'Profile updated successfully!';
			} else {
				$_SESSION['danger'] = 'Something went wrong!';
			}
			return redirect()->to('/home/profile?success_data=true');
		} else {

			$_SESSION['danger'] = 'Something went wrong!';
			return redirect()->to('/');
		}
	}
	public function changePassword()
	{
		$wrong_data = array(
			'status' => 'false',
			'message' => '* Incorrect Old Password'
		);
		session_start();
		if ($_POST['id'] == $_SESSION['user_data']['id']) {
			$users = new Users();
			$user_data = $users->getrow($_POST['id']);
			$encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			if (password_verify($_POST['oldpassword'], $user_data['password'])) {
				$users->update($_POST['id'], [
					'password' => $encrypted_password,
				]);
				if (isset($users)) {
					$_SESSION['success'] = 'Password updated successfully!';
				} else {
					$_SESSION['danger'] = 'Something went wrong!';
				}
				return json_encode(base_url() . "/home/profile?success_ps=true");
			} else {
				return json_encode($wrong_data);
			}
		} else {
			$_SESSION['danger'] = 'Something went wrong!';
			return redirect()->to('/');
		}
	}
	public function sendOtp()
	{
		log_message('debug', '***************** send otp *****************');
		$alphabet = '1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$users = new Users();
		$user_data = $users->getrow($_POST['userid']);
		$emailslib = new Emails();
		$code = implode($pass);
		$users->update($user_data['id'], [
			'otp' => $code,
		]);
		log_message('debug', '***************** Login verification *****************' . $code . " " . $user_data['email']);
		$fullName = $user_data['firstName'];

		$emailslib->sendOtp($user_data['email'], $code, $fullName);
	}

	public function verify()
	{
		log_message('debug', '***************** Login verification *****************');
		// session_start();
		$wrong_data = array(
			'status' => 'false',
			'message' => '* Incorrect Email or Password'
		);
		$deleteUser = array(
			'status' => 'false',
			'message' => '* Your account has been deleted. For more information, please contact us at contact@golongclients.com'
		);
		$form_email = $_POST['emailaddress'];
		$form_password = $_POST['password'];
		$users = new Users();
		$attempt = new LoginAttempt();
		$ip = $this->request->getIPAddress();
		$user_data = $users->getuser_email($form_email);
		log_message('debug', 'User IP: ' . $ip);
		log_message('debug', "Email: " . $form_email . " Password: " . var_export($user_data, true));
		// log_message('debug', "Email: " . $form_email . " Password: " . $user_data);
		if ($user_data != NULL) {
			if ($user_data['isDeleted'] == 'Y' || $user_data['userTypeId'] == 3) {
				return json_encode($deleteUser);
			} else {
				if (password_verify($form_password, $user_data['password'])) {
					$email = $form_email;
					// $GLOBALS['nvest']['user_data'] = $user_data;
					// log_message('debug', 'User login: ' . $_SESSION['email']);
					$attempt->save([
						'userid' => $user_data['id'],
						'ip' => $ip,
						'status' => 'Success',
					]);
					// $users->tokenUpdate($token , $user_data['id']) ;
					return json_encode(base_url() . '/user/verify?uid=' . $user_data['id']);
				} else {
					// Incorrect username or password
					log_message('debug', 'User enters wrong password: ' . $form_email);
					$attempt->save([
						'userid' => $user_data['id'],
						'ip' => $ip,
						'status' => 'Fail',
					]);
					return json_encode($wrong_data);
				}
			}
		} else {
			// Incorrect username or password
			log_message('debug', 'No user Exist: ' . $form_email);

			$attempt->save([
				'userid' => 'User Not Find',
				'ip' => $ip,
				'status' => 'Fail',
			]);
			return json_encode($wrong_data);
		}
	}
	public function update_device_token()
	{
		session_start();
		$users = new Users();
		$message = "";
		$user_data = $users->getuser_email($_SESSION['user_data']['email']);
		$token = $_POST['device_token'];
		if ($user_data['token'] != NULL) {
			$append = true;
			$arr = array();
			$d =  unserialize($user_data['token']);
			// 		log_message("debug" , "Data type ".gettype($d)) ;
			if (gettype($d) == "string") {
				if ($d != $token) {
					$message = "Token Update";
					array_push($arr, $d);
					array_push($arr, $token);
				} else {
					$message = "Token Already Exist";
					array_push($arr, $d);
				}
				$data = serialize($arr);
			} else {
				foreach ($d as $key => $value) {
					if ($value == $token) {
						$append = false;
					}
				}
				if ($append) {
					$tok = explode(":", $token);
					$find = 0;
					for ($i = 0; $i < sizeof($d); $i++) {
						$old_tok = explode(":", $d[$i]);
						if ($old_tok[0] == $tok[0]) {
							$d[$i] = $token;
							$find++;
						}
					}
					if ($find == 0) {
						array_push($d, $token);
					}
				}
				$data = serialize($d);
			}
			log_message("debug", "Serialize Data" . var_export($d, true));
		} elseif (isset($_POST['device_token'])) {
			$data = serialize($token);
		}
		if (isset($_POST['device_token']))
			$message = "Token Update in database";
		$users->where('id', $user_data['id'])->update($users, [
			'token' => $data,
		]);
		return json_encode($message);
	}
	public function saveSignupData()
	{
		// log_message('debug', '***************** SignUp *****************');
		session_start();
		$email_exist = array(
			'status' => 'false',
			'message' => 'Account already exists against this email. Please use a different email address to create a new account.'
		);
		$users = new Users();
		$email = $_POST['inputEmail4'];
		$response_email = $users->getuser_email($email);

		if ($response_email == NULL) {
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!*&?()$%#@1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			$emailslib = new Emails();
			$password = implode($pass); //turn the array into a string;
			$encrypted_password = password_hash($password, PASSWORD_DEFAULT);
			$data = [
				'firstName' => $_POST['firstname'],
				'lastName' => $_POST['lastname'],
				'email' => $email,
				'password' => $encrypted_password,
				'phone' => $_POST['phone'],
				'userTypeId' => $_POST['userTypeId'],				//2 is for customers
				'uniqueCode' => md5(uniqid(rand(), true))
			];
			if (isset($_POST)) {
				$users->save($data);

				// Sending a mail to user
				$fullname = $_POST['firstname'] . " " . $_POST['lastname'];
				// $emailslib->accountCreationEmail($email, $password, $fullname);

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, "https://golongclients.com/user_creation");
				curl_setopt($curl, CURLOPT_POST, TRUE);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "email=$email&password=$password&name=$fullname");
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
				curl_setopt($curl,  CURLOPT_TIMEOUT_MS, 500);
				curl_exec($curl);

				curl_close($curl);
				log_message('debug', 'Record Saved in Database: ' . $email);
				if (isset($users)) {
					$_SESSION['success'] = 'User added successfully!';
				} else {
					$_SESSION['danger'] = 'Something went wrong!';
				}
				return json_encode(base_url("/admin/usercreatedsuccess"));
			}
		} else {
			// This email is used before....
			// log_message('debug', 'Account already Exist on this email: ' . $email);
			$_SESSION['danger'] = 'Account already Exist on this email: ' . $email;
			return json_encode(base_url("/admin/createuser"));
		}
	}

	public function submitForgetPassword()
	{
		log_message('debug', '***************** Forgot Password *****************');
		$userNotFound = array(
			'status' => 'false',
			'message' => '* No user exists on this email please enter correct one'
		);
		$userFound = array(
			'status' => 'true',
			'message' => "We have sent you an email, please see the instructions to reset your password. If you don't recieve an email please check your spam tab."
		);
		$users = new Users();
		$emailslib = new Emails();
		$email = $_POST['email'];
		$response_email = $users->getuser_email($email);
		if ($response_email == NULL) {
			return json_encode($userNotFound);
		} else {
			$code = $response_email['uniqueCode'];
			//Sending Email to user
			$msg = '<a href="' . base_url() . '/home/resetPassword?code=' . $code . '">Update Password</a>';
			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg, 70);
			// send email
			// mail($response_email['email'], "Update your password", $msg);
			$userName = $response_email['firstName'] . " " . $response_email['lastName'];
			$emailslib->sendreset_ps($response_email['email'], $code, $userName);
			return json_encode($userFound);
		}
	}

	public function resetPassword()
	{
		$uniqueCode = $_GET['code'];
		// exit;
		$users = new Users();
		$getUser = $users->getUserByCode($uniqueCode);
		if ($getUser != NULL) {
			$data = [];
			$data['user'] = $getUser;
			return view('/home/newPassword', $data);
		} else {
			return redirect()->to('/');
		}
	}

	public function updatePassword()
	{
		$users = new Users();
		$encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$users->update($_POST['id'], [
			'password' => $encrypted_password,
			'uniqueCode' => md5(uniqid(rand(), true))
		]);
		return json_encode(base_url());
	}
	public function loginSuperAdmin()
	{
		return view('/home/loginSuperAdmin');
	}
	public function superAdminverify()
	{
		log_message('debug', '***************** Login verification *****************');
		// session_start();
		$wrong_data = array(
			'status' => 'false',
			'message' => '* Incorrect Email or Password'
		);
		$errormsg = array(
			'status' => 'false',
			'message' => '* You are not allow to access'
		);
		$deleteUser = array(
			'status' => 'false',
			'message' => '* User Not Exist'
		);
		$form_useremail = $_POST['useremailAddress'];
		$form_email = $_POST['emailaddress'];
		$form_password = $_POST['password'];
		// log_message('debug', "Email: " . $form_email . " Password: " . $form_password . "UserEmail" . $form_useremail);
		$users = new Users();
		$user_data =  $users->getuser_email($form_useremail);
		$admin_data = $users->getuser_email($form_email);
		// log_message('debug', "Email: " . var_export($admin_data, true));
		if ($user_data != NULL) {
			if ($user_data['isDeleted'] == 'Y'  || $user_data['userTypeId'] == 1) {
				return json_encode($deleteUser);
			} else {
				if (isset($admin_data) && $admin_data) {
					if ($form_email == $admin_data['email'] && $admin_data['userTypeId'] == 3) {
						if (password_verify($form_password, $admin_data['password'])) {
							$email = $form_email;
							$sid[] = $user_data['sessionid'];
							// $GLOBALS['nvest']['user_data'] = $user_data;
							// log_message('debug', 'User login: ' . $_SESSION['email']);
							session_start($sid);
							$_SESSION['email'] = $user_data['email'];
							$_SESSION['user_data'] = $user_data;
							$_SESSION['superAdminTypeId'] = $admin_data['userTypeId'];
							return json_encode(base_url() . '/user/dashboard?uid=' . $user_data['id']);
						} else {
							// Incorrect username or password
							log_message('debug', 'User enters wrong password: ' . $form_email);
							return json_encode($wrong_data);
						}
					} else {
						// Incorrect username or password
						log_message('debug', 'No user Exist: ' . $form_email);
						return json_encode($errormsg);
					}
				} else {
					// Incorrect username or password
					log_message('debug', 'No user Exist: ' . $form_email);
					return json_encode($wrong_data);
				}
			}
		} else {
			// Incorrect username or password
			log_message('debug', 'No user Exist: ' . $form_email);
			return json_encode($deleteUser);
		}
	}
	public function updateProfileImage()
	{
		// log_message('debug', 'send_user_creation_email: '.var_export($_FILES["profile_photo"]["name"],true));
		session_start();
		$id = $_SESSION['user_data']['id'];
		$ext = pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION);
		$target_dir = "assets/images/users/";
		if ($_SESSION['user_data']['profile_img']) {
			if (file_exists($_SESSION['user_data']['profile_img'])) {
				unlink($_SESSION['user_data']['profile_img']);
			}
		}
		$target_dir = $target_dir . 'user_id-' . $id . '.' . $ext;
		$users = new Users();
		if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_dir)) {
			// echo $id.' ................ '.$target_dir;
			$users->update($id, [
				'profile_img' => '/' . $target_dir
			]);
			$_SESSION['user_data']['profile_img'] = '/' . $target_dir;
		} else {
			// echo "Sorry, there was an error uploading your file.";
		}
		return redirect()->to('/home/profile?success=true');
	}
	public function send_user_creation_email()
	{
		// log_message('debug', 'send_user_creation_email: '.var_export($_POST,true));
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$emailslib = new Emails();
		$emailslib->accountCreationEmail($email, $password, $name);
	}
}
