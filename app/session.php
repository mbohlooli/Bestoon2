<?php


class Session
{

    private $logged_in = false;
    public $user_id;
    private $last_access;

    public function __construct()
    {
        session_start();
        $this->check_login();
        if($this->logged_in) {
            //TODO: actions to take right away if user is logged in
        } else {
            //TODO: actions to take right away if user is not logged in
        }
    }

    public function is_logged_in()
    {
        return $this->logged_in;
    }

    public function login($user)
    {
        // database should find user based on username/password
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user[0]->id;
            $this->last_access = $_SESSION['last_access'] = time();
            $this->logged_in = true;
            redirect_to(home_url('dashboard'));
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    private function check_login()
    {
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
        $this->last_access = 0;
        if(isset($_SESSION['last_access'])) {
            $this->last_access = $_SESSION['last_access'];
        }
        // setting limit for duration of bieng logged after closing tab or browser
        $expired = ((time() - $this->last_access) > SESSION_EXPIRATION_TIME);
        if($expired) {
            $this->logout();
        }
    }
}