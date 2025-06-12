<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        helper('form');
        echo view('templates/header');
        echo view('auth/register');
        echo view('templates/footer');
    }

    public function processRegister()
    {
        helper('form');
        $userModel = new UserModel();

        $rules = [
            'username'     => 'required|alpha_numeric|min_length[3]',
            'email'        => 'required|valid_email',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'matches[password]'
        ];

        if (! $this->validate($rules)) {
            echo view('templates/header');
            echo view('auth/register', [
                'validation' => $this->validator
            ]);
            echo view('templates/footer');
            return;
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        $userModel->save($data);

        session()->setFlashdata('success', 'Registrasi berhasil. Silakan login.');
        return redirect()->to('/login');
    }

    public function login()
    {
        helper('form');
        echo view('templates/header');
        echo view('auth/login');
        echo view('templates/footer');
    }

    public function processLogin()
    {
        helper('form');
        $userModel = new UserModel();

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            echo view('templates/header');
            echo view('auth/login', [
                'validation' => $this->validator
            ]);
            echo view('templates/footer');
            return;
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set([
                'id'          => $user['id'],
                'username'    => $user['username'],
                'isLoggedIn'  => true,
            ]);
            return redirect()->to('/topup');
        } else {
            session()->setFlashdata('error', 'Username atau password salah.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
