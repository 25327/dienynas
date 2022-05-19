<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\LessonModel;
use App\Models\TeacherModel;
use App\Models\UserModel;
use App\Models\StudentModel;

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
            'teachers' => (new TeacherModel)->findAllWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];

        return view('users/director/home', $data);
    }

    public function teachers()
    {
        $data = [
            'lessons' => (new LessonModel())->findAll(),
            'classes' => (new ClassModel)->findAll(),
            'teachers' => (new TeacherModel)->findAllWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];
        return view('users/director/teachers', $data);
    }

    public function classes()
    {
        $data = [
            'classes' => (new ClassModel)->findAll(),
        ];
        return view('users/director/classes', $data);
    }

    public function lessons()
    {
        $data = [
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
            'lessons' => (new LessonModel)->findAll()
        ];
        return view('users/director/lessons', $data);
    }

    public function students($id = null)
    {
        $data = [
            'classes' => (new ClassModel)->findAll(),
            'students' => (new StudentModel())->getWithRelations(),
            'errors' => $this->session->getFlashdata('errors') ?? null,
            'success' => $this->session->getFlashdata('success') ?? null,
        ];
        if ($id != null) {
            $data['student'] = (new StudentModel)->getWithRelations($id);
        }
        return view('users/director/students', $data);
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

    public function editTeacher(int $id)
    {
        $teacher = (new TeacherModel())->getFullData($id);
        if ($teacher) {
            $data = [
                'lessons' => (new LessonModel)->findAll(),
                'classes' => (new ClassModel())->findAll(),
                'teacher' => $teacher,
            ];

            return view('users/director/teacher_edit', $data);
        }
        return redirect()->to(base_url('/director/index'))->with('errors', 'Mokytojas nerastas');
    }

    public function updateTeacher(int $id)
    {
        $teacher = (new TeacherModel())->getFullData($id);
        if ($teacher) {
            if ($this->validate([
                'password' => 'permit_empty|min_length[2]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $teacher['user_id'] . ']',
                'firstname' => 'required|min_length[2]|max_length[60]',
                'lastname' => 'required|min_length[2]|max_length[60]',
                'lesson_id' => 'permit_empty|is_not_unique[lessons.id]',
                'class_id' => 'permit_empty|is_not_unique[classes.id]',
            ])) {
                $userData = [
                    'email' => $this->request->getVar('email'),
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                ];

                $password = $this->request->getVar('password') ?? null;
                if ($password != null) {
                    $userData['password'] = md5($this->request->getVar('password'));
                }

                (new UserModel())->update($teacher['user_id'], $userData);

                (new TeacherModel())->update($id, [
                    'lesson_id' => $this->request->getVar('lesson_id') ?? null,
                    'class_id' => $this->request->getVar('class_id') ?? null,
                ]);

                return redirect()->to(base_url('/director/index'))->with('success', 'Mokytojas sėkimingai atnaujintas');
            }
        }
        return redirect()->to(base_url('/director/index'))->with('errors', 'mokytojas nerastas');
    }

    public function createStudent()
    {
        if ($this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[2]',
            'firstname' => 'required|min_length[2]|max_length[60]',
            'lastname' => 'required|min_length[2]|max_length[60]',
            'class_id' => 'permit_empty|is_not_unique[classes.id]',
        ])) {
            $user_data = [
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password'),
                'firstname' => $this->request->getVar('firstname'),
                'lastname' => $this->request->getVar('lastname'),
                'type' => 'student',
            ];

            $user_id = (new UserModel)->insert($user_data);

            $student_data = [
                'user_id' => $user_id,
                'class_id' => $this->request->getVar('class_id') ?? null,
            ];

            (new StudentModel)->insert($student_data);

            return redirect()->to(base_url('/director/students'))->with('success', 'Mokinys sekmingai sukurtas');
        } else {
            return redirect()->to(base_url('/director/students'))->with('errors', $this->validator->listErrors());
        }
    }

    public function updateStudent(int $id)
    {
        $student = (new StudentModel())->getWithRelations($id);
        if ($student) {
            if ($this->validate([
                'email' => 'required|valid_email|is_unique[users.email,id,' . $student['user_id'] . ']',
                'password' => 'permit_empty|min_length[2]',
                'firstname' => 'required|min_length[2]|max_length[60]',
                'lastname' => 'required|min_length[2]|max_length[60]',
                'lesson_id' => 'permit_empty|is_not_unique[lessons.id]',
                'class_id' => 'permit_empty|is_not_unique[classes.id]',
            ])) {
                $userData = [
                    'email' => $this->request->getVar('email'),
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                ];

                $password = $this->request->getVar('password') ?? null;
                if ($password != null) {
                    $userData['password'] = md5($this->request->getVar('password'));
                }
                (new UserModel())->update($student['user_id'], $userData);

                (new StudentModel())->update($id, [
                    'class_id' => $this->request->getVar('class_id') ?? null,
                ]);
                return redirect()->to(base_url('/director/students'))->with('success', 'Mokinys atnaujintas');
            }
        }
        return redirect()->to(base_url('/director/students'))->with('errors', 'Mokinys nerastas');
    }

    public function deleteStudent($id)
    {
        $student = (new StudentModel())->find($id);
        if ($student) {
            (new UserModel())->delete($student['user_id']);
            (new StudentModel())->delete($student['id']);

            return redirect()->to(base_url('/director/students'))->with('success', 'Mokinys ištrintas');
        }
        return redirect()->to(base_url('/director/students'))->with('errors', 'Mokinys nerastas');
    }

    public function createLesson()
    {
        if ($this->validate([
            'title' => 'required|min_length[2]|max_length[30]',
        ])) {
            (new LessonModel())->insert([
                'title' => $this->request->getVar('title'),
            ]);

            return redirect()->to(base_url('/director/lessons'))->with('success', 'Pamoka sėkmingai sukurta');
        } else {
            return redirect()->to(base_url('/director/lessons'))->with('errors', $this->validator->listErrors());
        }
    }
}
