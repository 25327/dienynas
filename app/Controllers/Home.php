<?php

namespace App\Controllers;

use App\Models\User;

class Home extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[2]',
        ])) {

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $user = (new User())->where('email', $email)->where('password', md5($password))->first();

            if (!$user) {
                $this->validator->setError('email', 'Bad password');
            } else {
                $this->session->set('user_id', $user['id']);
                switch ($user['type']) {
                    case 'director':
                        $route = '/director/index';
                        break;
                    case 'teacher':
                        $route = '/teacher/index';
                        break;
                    case 'student':
                        $route = '/student/index';
                        break;
                }

                return redirect()->to(base_url($route));
            }
        }

        return view('login', ['errors' => $this->validator->listErrors()]);
    }
}
