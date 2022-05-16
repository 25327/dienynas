<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\UserModel;

class Director extends BaseController
{
    public function __construct()
    {
        if (session()->user['type'] != 'director') {
            dd('galima tik direktoriui');
        }
    }

    public function index()
    {
        $data = [
            'lessons' => (new LessonModel)->findAll(),
            'classes' => (new ClassModel)->findAll(),
            'teachers' => (new TeacherModel)->findAll(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];

        return view('users/director', $data);
    }

    public function createTeacher()
    {
        if ($this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[2]',
            'firstname' => 'required|min_length[2]|max_length[60]',
            'lastname' => 'required|min_length[2]|max_length[60]',
            'lesson_id' => 'permit_empty|is_not_unique[lessons.id]',
            'class_id' => 'permit_empty|is_not_unique[classes.id]',
        ])) {
            $user_data = [
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password'),
                'firstname' => $this->request->getVar('firstname'),
                'lastname' => $this->request->getVar('lastname'),
                'type' => 'teacher',
            ];

            $user_id = (new UserModel)->insert($user_data);

            $teacher_data = [
                'user_id' => $user_id,
                'lesson_id' => $this->request->getVar('lesson_id') ?? null,
                'class_id' => $this->request->getVar('class_id') ?? null,
            ];

            (new TeacherModel)->insert($teacher_data);

            return redirect()->to(base_url('/director/index'))->with('success', 'Mokytojas sekmingai sukurtas');
        } else {
            return redirect()->to(base_url('/director/index'))->with('errors', $this->validator->listErrors());
        }
    }
}
