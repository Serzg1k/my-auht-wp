<?php 

/**
* 
*/
class MyUserAuth
{
	protected $password;
	protected $login;
	protected $email;

	
	function __construct($pass, $email, $login)
	{
		$this->password = $pass;
		$this->email = sanitize_email($email);
		$this->login = trim(esc_attr($login));
	}

	function registration(){

		if(strlen($this->password) <= 6) wp_die('password_reqwaired');

		if(!is_email($this->email)) wp_die($this->email);
		
		if(email_exists($this->email))wp_die('email_isset');

		if(username_exists($this->login))wp_die('nickname_isset');

		$userdata = [
                'user_pass'  => $this->password,
                'user_login' => $this->login,
                'user_email' => $this->email,
                ];

    	$user_id = wp_insert_user( $userdata );

	    $info = [];
	    $info['user_login'] = $this->email;
	    $info['user_password'] = $this->password;
	    $info['remember'] = true;

	    $user_signon = wp_signon( $info, false );
	    // $this->sendEmail();
	    wp_die('user_registration');
		}

	function auth(){

		$info = [];
		$info['user_login'] = $this->email;
    	$info['user_password'] = $this->password;
    	$info['remember'] = true;

    	$user_signon = wp_signon( $info, false );

		if ( is_wp_error($user_signon) ){
			wp_die('incorect_auth');
	    } else {
	    	wp_die('success_auth');
	    }
	}

	function forgot(){

		if(!email_exists($this->email)){
			wp_die('email_not_found');
		}

	  	$new_pass = wp_generate_password();
	  	$user = get_user_by( 'email', $this->email );
	  	wp_set_password( $new_pass, $user->ID );
		// $this->sendEmail($this->email, 'New password', 'Your password - ' . $new_pass);	  	
	  	wp_die('resert_pass');
	}

	function sendEmail($to, $subject,$message){
		wp_mail( $to, $subject, $message );
	}




}