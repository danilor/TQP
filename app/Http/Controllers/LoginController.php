<?php namespace GlobalC\Http\Controllers;
use Illuminate\Support\Str;
use Request;
use Input;
use Redirect;
use Auth;
use Validator;
use Config;
use Hash;

//This class will take care of the login information
class IngresoControllador extends Controller {


	public function __construct(){
		//$this->middleware('guest');
	}


	public function ingreso(){
		$data = [];
		if(Auth::check()){
			return Redirect::to("/");
		}
		return view('login.login')->with($data);
	}
	
	public function forgot(){
		if(Auth::check()){
			return Redirect::to("/home");
		}
		$data = array();
		$data["title"] = Str::title(trans('messages.forgot_password'));
		$data["button"] = Str::title(trans('messages.log-in'));
		$data["user"] = Str::title(trans('messages.username'));
		$data["password"] = Str::title(trans('messages.password'));
		return view('login.forgot')->with($data);
	}

	public function recover(){
		Auth::logout();
		$data = array();
		$token = Request::segment(2);
		$tokenValid = Login::checkUserToken($token);

		$data["title"] = Str::title(trans('messages.recover'));
		$data["button"] = Str::title(trans('messages.log-in'));
		$data["user"] = Str::title(trans('messages.username'));
		$data["password"] = Str::title(trans('messages.password'));
		$data["validToken"] = $tokenValid;
		return view('login.recover')->with($data);
	}

	public function doRecover(){
		Auth::logout();
		\Session::flush();
		$data = array();
		$token = Request::segment(2);
		$tokenValid = Login::checkUserToken($token);

		if(!$tokenValid){
			return Redirect::to(Request::fullUrl())->withErrors([ucfirst(trans('messages.forgot_password_recover_bad'))]);
		}
		$rules['password']              	=  Common::getValRule("password", true, 'confirmed');

		$validator = Validator::make(Input::all(), $rules);
		if ($validator -> fails()){
			return Redirect::to(Request::fullUrl())->withErrors($validator);
		}
		//if everything is fine, lets update the user

		$id = Login::getUserIdByToken($token);
		$data["password"] = Hash::make(Input::get("password"));


		GUsers::updateUser($id,$data);
		Login::closeAllRecoversByUser($id);
		Logs::saveLog("users","recover","password",$id);

		return Redirect::to("/login?chan");
	}

	//This function is suppose to get the login valid or not, and if valid, then return to the original screen. If not, then show the error
	
	public function doLogin(){
		if(Auth::check()){
			return Redirect::to("/home");
		}

		// process the form
		$originalPath = "/";
		if(Request::input("path") != null && Request::input("path") != ""){
			$originalPath = Request::input("path"); 
		}
		$rules = array(
			'email'              	=>  Common::getValRule("email", true),
			'password'              =>  Common::getValRule("password", true),
		);
		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('/login')
					->withErrors($validator) // send back all errors to the login form
					->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {
			$remember = false;
			$r = Input::get('remember');
			if(($r)=="y"){
				$remember = true;
			}
			// create our user data for the authentication
			$userdata = array(
				'email' 		=> 	Input::get('email'),
				'password' 		=> 	Input::get('password'),
                'status'        => 	'1',
				'licenced'		=>	'1',
			);
			// attempt to do the login
			if (Auth::attempt($userdata,$remember)) {
                   //We have to store the login log (this log is a successfull one)
                   $GUser = new GUser(Auth::user()->id,Auth::user());
				   if($GUser->organization->isValid() == false){
				   		Auth::logout();
		 				\Session::flush();
				   		return Redirect::to('/login?oe')->withInput(Input::except('password','_token')); // send back the input (not the password) so that we can repopulate the form
				   }
                   Login::logLogin(Auth::user()->id);
				Logs::saveLog("login","success","",Auth::user()->id);
				return Redirect::to($originalPath);
			} else {
				return Redirect::to('/login?e')->withInput(Input::except('password','_token')); // send back the input (not the password) so that we can repopulate the form
			}
		}
	}

	public function doForgot(){
		if(Auth::check()){
			return Redirect::to("/home");
		}

		// process the form
		$originalPath = "/";
		if(Request::input("path") != null && Request::input("path") != ""){
			$originalPath = Request::input("path");
		}
		$rules = array(
			'email'              =>  Common::getValRule("email", true),
		);
		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('/forgot_password')
				->withErrors($validator); // send back all errors to the login form
		} else {
			$remember = false;
			$r = Input::get('remember-me');
			if(($r)=="1"){
				$remember = true;
			}
			// create our user data for the authentication

				$GUser = GUsers::findUserByEmail(Input::get("email"));
				if($GUser != null){

						//We have to store the token and everything else
					$token = Login::log_forgot_password($GUser->id);
					//echo $token;


					$link = Request::root()."/recover_password/$token";
					//We have to send the email now
					$body = trans("mail_messages.forgot_password.body");
					$body = str_replace("[LINK]", $link, $body);
					$emailData = ['title' => trans("mail_messages.forgot_password.title"),'content'=>$body];
					Email::sendEmail(trans("mail_messages.forgot_password.subject"),'emails.basic',$emailData,$GUser->email,$GUser->getFullName());

				}

			return Redirect::to("/login?snd");
		}
	}

	//This will only generate the logout function. It doesnt have a page or anything similar
	public function dologout(){
		echo "Please wait"; //This line shouldnt appear. If it does then something is wrong.
		Auth::logout();
		 \Session::flush();
		return Redirect::to("/");
	}


}
