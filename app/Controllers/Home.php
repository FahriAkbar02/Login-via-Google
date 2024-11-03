<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\CourseModel;

class Home extends BaseController
{
    protected $users;
    protected $db;
    protected $session;
    protected $courseData;
    protected $enrollments;
    protected $googleClient;
    protected $assignments;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = $this->db->table('users');
        $this->courseData = $this->db->table('courses');
        $this->enrollments = $this->db->table('enrollments');
        $this->assignments = $this->db->table('assignments');
    }

    public function index()
    {
        return view('dashboard/index');
    }

    private function getUserData()
    {
        $googleId = session()->get('google_id');
        $userData = $this->users
            ->where('id', $googleId)
            ->get()
            ->getRow();

        return $userData;
    }
    public function tentang()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->db->table('users')->where('id', $userId)->get()->getRow();

        $userCourses = $this->courseData->where('user_id', $userId)->get()->getResultArray();

        // Ambil data kursus yang diikuti oleh pengguna
        $this->enrollments->select('courses.*, users.username as username, users.profile as profile');
        $this->enrollments->join('courses', 'courses.id = enrollments.course_id');
        $this->enrollments->join('users', 'users.id = courses.user_id');
        $this->enrollments->where('enrollments.user_id', $userId);
        $joinedCourses = $this->enrollments->get()->getResultArray();

        return view('course/tentang', ['userCourses' => $userCourses, 'joinedCourses' => $joinedCourses, 'userData' => $userData]);
    }
}
