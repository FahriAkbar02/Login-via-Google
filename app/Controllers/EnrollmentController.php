<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;

class EnrollmentController extends BaseController
{
    protected $db;
    protected $users;
    protected $courseData;
    protected $enrollments;
    protected $assignments;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = $this->db->table('users');
        $this->courseData = $this->db->table('courses');
        $this->enrollments = $this->db->table('enrollments');
        $this->assignments = $this->db->table('assignments');
    }
    public function enroll()
    {
        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'course_id' => $this->request->getPost('course_id'),
            // Ambil peran dari pengguna
            'role' => $this->getRole($this->request->getPost('user_id'), $this->request->getPost('course_id'))
        ];

        $enrollmentModel = new EnrollmentModel();
        $enrollmentModel->save($data);
    }

    protected function getRole($userId, $courseId)
    {
        $userData = $this->users->where('id', $userId)->get()->getRow();

        if ($userData->role === 'guru') {
            return $userData->role;
        }

        $courseData = $this->courseData->where('id', $courseId)->get()->getRow();
        return $courseData->role;
    }
}
