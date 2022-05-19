<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeacherModel;
use App\Models\ClassModel;

class Teacher extends BaseController
{
    public function __construct()
    {
        if (session()->user['type'] != 'teacher') {
            dd('galima tik mokytojui');
        }
    }

    public function index()
    {
        $teacher = (new TeacherModel())->where('user_id', session()->user['id'])->first();
        $data = [
            'students' => (new ClassModel())->getStudents($teacher['class_id']),
        ];

        if ($teacher['class_id'] != null) {
            $data['class'] = (new ClassModel())->find($teacher['class_id']);
        }

        return view('users/teacher', $data);
    }
}
