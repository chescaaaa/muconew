<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\InventoryModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class UserController extends ResourceController
{
    use ResponseTrait;
    protected $session;

    public function __construct(){
        $this->session = \Config\Services::session();
    }
    public function loginView()
    {
        return view('user/login');
    }

    public function registerView()
    {
        return view('user/register');
    }
    public function login()
{
    if ($this->request->getMethod() === 'post') {
        $FirstName = $this->request->getVar('firstname');
        $LastName = $this->request->getVar("lastname");
        $Email = $this->request->getVar("email");
        $Password = $this->request->getVar("password");
        $Phone = $this->request->getVar("phone");

        $user = new UserModel();
        $data = $user->where("email", $Email)->first();

        if ($data) {
            $storedPassword = $data['Password'];
            $authenticatedPassword = password_verify($Password, $storedPassword);

            if ($authenticatedPassword) {
                return redirect()->to('/index');
            } else {
                $alertMessage = 'Invalid password. Please try again.';
                $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
                return redirect()->to('/login');
            }
        } else {
            $alertMessage = 'No user found with the provided email. Please check your email and try again.';
            $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
            return redirect()->to('/login');
        }
    } else {
        return redirect()->to('/homepage');
    }
}

public function logout(){
    return view('user/login');
}

    public function website(){
        return view('website/index_2');
    }

    public function register()
{
    if ($this->request->getMethod() === 'post') {
        $user = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $phone = $this->request->getVar('phone');
        $municipality = $this->request->getVar('municipality');
        $barangay = $this->request->getVar('barangay');
        $sitio = $this->request->getVar('sitio');

        // Check if the email already exists
        if ($user->where('email', $email)->countAllResults() > 0) {
            $alertMessage = 'Email already in use. Please use a different email address.';
            $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
            return redirect()->to('/register');
        }

        // Check if the password meets the minimum length and is alphanumeric
        if (strlen($password) < 8 || !ctype_alnum($password)) {
            $alertMessage = 'Password must be at least 8 characters long and alphanumeric.';
            $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
            return redirect()->to('/register');
        }

        // Check if the phone number has exactly 11 digits
        if (strlen($phone) !== 11) {
            $alertMessage = 'Phone number must be exactly 11 digits.';
            $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
            return redirect()->to('/register');
        }

        $token = $this->verification(50);
        $data = [
            'FirstName' => $this->request->getVar('firstname'),
            'LastName' => $this->request->getVar("lastname"),
            'Email' => $email,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'Municipality' => $municipality,
            'Barangay' => $barangay,
            'Sitio' => $sitio,
            'Phone' => $phone,
            'Token' => $token,
            'Status' => 'active',
            'Role' => 'user',
        ];

        $u = $user->save($data);
        if ($u) {
            return redirect()->to('/login');
        } else {
            $alertMessage = 'Registration failed. Please try again.';
            $this->session->setFlashdata('alert', ['type' => 'danger', 'message' => $alertMessage]);
            return redirect()->to('/register'); // Redirect back to the registration view
        }
    } else {
        return redirect()->to('/login');
    }
}
public function verification($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }
  
    public function index()
    {
        //
    }
}
