<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CourseController extends Controller
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
    public function index()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->db->table('users')->where('id', $userId)->get()->getRow();

        $userCourses = $this->courseData->where('user_id', $userId)->get()->getResultArray();

        $this->enrollments->select('courses.*, users.username as username, users.profile as profile');
        $this->enrollments->join('courses', 'courses.id = enrollments.course_id');
        $this->enrollments->join('users', 'users.id = courses.user_id');
        $this->enrollments->where('enrollments.user_id', $userId);
        $joinedCourses = $this->enrollments->get()->getResultArray();
        return view('course/index_course', ['userCourses' => $userCourses, 'joinedCourses' => $joinedCourses, 'userData' => $userData]);
    }


    public function userCourses($userId)
    {
        if (!session()->get('google_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->db->table('users')->where('id', $userId)->get()->getRow();
        $userCourses = $this->courseData->where('user_id', $userId)->get()->getResultArray();
        $this->enrollments->select('courses.*, users.username as username, users.profile as profile');
        $this->enrollments->join('courses', 'courses.id = enrollments.course_id');
        $this->enrollments->join('users', 'users.id = courses.user_id');
        $this->enrollments->where('enrollments.user_id', $userId);
        $joinedCourses = $this->enrollments->get()->getResultArray();
        return view('course/index_course', ['userCourses' => $userCourses, 'joinedCourses' => $joinedCourses, 'userData' => $userData]);
    }
    public function detail($id)
    {
        if (!session()->get('google_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $course = $this->courseData->where('id', $id)->get()->getRow();

        // Mengambil daftar id pengguna yang terdaftar dalam kursus
        $participantIds = $this->enrollments->where('course_id', $id)->get()->getResult();
        $enrolledUsers = [];
        foreach ($participantIds as $participant) {
            $userId = $participant->user_id;
            $userData = $this->users->where('id', $userId)->get()->getRow();
            if ($userData) {
                $enrolledUsers[] = $userData;
            }
        }
        $assignments = $this->assignments
            ->select('assignments.*, users.username AS creator_username,users.profile AS creator_profile')
            ->join('courses', 'courses.id = assignments.course_id')
            ->join('users', 'users.id = courses.user_id')
            ->where('assignments.course_id', $id)
            ->get()
            ->getResult();
        $userId = session()->get('google_id');
        $userData = $this->users->where('id', $userId)->get()->getRow();

        // Mengecek apakah pengguna adalah pembuat tugas
        $isCreator = ($course->user_id === $userId);

        return view('course/detail_course', ['course' => $course, 'userData' => $userData, 'enrolledUsers' => $enrolledUsers, 'assignments' => $assignments, 'isCreator' => $isCreator]);
    }


    public function daftarCourse()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $userCourses = $this->enrollments
            ->select('courses.*')
            ->join('courses', 'enrollments.course_id = courses.id')
            ->where('enrollments.user_id', $userId)
            ->get()
            ->getResultArray();
        return view('course/userCourses', ['userCourses' => $userCourses]);
    }

    protected function generateCourseCode()
    {
        try {
            $courseCode = 'COURSE_' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
            return $courseCode;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function share($courseCode)
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $course = $this->courseData->where('user_id', $userId)->get()->getResultArray();
        $userData = $this->users->where('id', $userId)->get()->getRow();
        $course = $this->courseData->where('tautan', $courseCode)->get()->getRow();
        if (!$course) {
            return redirect()->to('/courses')->with('error', 'Course not found');
        }
        return view('course/share_course', ['course' => $course, 'userData' => $userData]);
    }
    public function create()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $userData = $this->users->where('id', $userId)->get()->getRow();
        return view('course/create_course', ['userData' => $userData]);
    }

    public function store()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'schedule' => $this->request->getPost('schedule'),
            'room' => $this->request->getPost('room'),
            'user_id' => $userId,
            'tautan' => $this->generateCourseCode()
        ];

        $userData = [
            'role' => 'guru'
        ];
        $this->users->where('id', $userId)->update($userData);

        $this->createNotification($userId, 'Kursus baru telah dibuat.');

        $this->courseData->insert($data);
        return redirect()->to('/course')->with('success', 'Kursus berhasil dibuat.');
    }

    protected function createNotification($userId, $message)
    {
        $notificationData = [
            'user_id' => $userId,
            'message' => $message,
        ];

        $this->db->table('notifications')->insert($notificationData);
    }



    public function showJoinForm()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $courses = $this->courseData->where('user_id', $userId)->get()->getResultArray();
        $userData = $this->users->where('id', $userId)->get()->getRow();
        return view('course/join_course', ['userData' => $userData, 'courses' => $courses]);
    }

    public function join()
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Mohon untuk login terlebih dahulu.');
        }

        $tautan = $this->request->getPost('tautan');
        $course = $this->courseData->where('tautan', $tautan)->get()->getRow();

        if (!$course) {
            return redirect()->back()->with('error', 'Kode kursus tidak valid.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();
        if ($userData->role === 'guru') {
            $this->users->where('id', $userId)->update(['role' => 'siswa']);
        }

        $alreadyJoined = $this->enrollments
            ->where('user_id', $userId)
            ->where('course_id', $course->id)
            ->get()->getRow();
        if ($alreadyJoined) {
            return redirect()->back()->with('error', 'Anda sudah bergabung dengan kursus ini.');
        }

        $participantData = [
            'user_id' => $userId,
            'course_id' => $course->id
        ];
        $this->enrollments->insert($participantData);
        return redirect()->to('/course')->with('success', 'Anda telah berhasil mengikuti kursus ini.');
    }


    protected function isUserEnrollment($userId, $courseId)
    {
        $participant = $this->enrollments->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->countAllResults();
        return ($participant > 0);
    }

    protected function addEnrollment($courseId, $userId)
    {
        $data = [
            'user_id' => $userId,
            'course_id' => $courseId
        ];

        $success = $this->enrollments->insert($data);
        return $success;
    }
    public function edit($id)
    {
        $userId = session()->get('google_id');
        $course = $this->courseData->where('id', $id)->get()->getRow();

        // Pastikan pengguna adalah pembuat kursus
        if ($course->user_id == $userId) {
            // Ambil data pengguna
            $userData = $this->users->where('id', $userId)->get()->getRow();

            return view('course/edit_course', ['course' => $course, 'userData' => $userData]);
        } else {
            return redirect()->to('/course')->with('error', 'Anda tidak memiliki izin untuk mengedit kursus ini.');
        }
    }

    public function update($id)
    {
        $userId = session()->get('google_id');
        $course = $this->courseData->where('id', $id)->get()->getRow();

        // Pastikan pengguna adalah pembuat kursus
        if ($course->user_id != $userId) {
            return redirect()->to('/course')->with('error', 'Anda tidak memiliki izin untuk mengedit kursus ini.');
        }

        // Ambil data yang diubah dari form
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'schedule' => $this->request->getPost('schedule'),
            'room' => $this->request->getPost('room'),
        ];

        // Perbarui data kursus
        $this->courseData->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Kursus berhasil diperbarui.');
    }
    public function delete($id)
    {
        $userId = session()->get('google_id');
        $course = $this->courseData->where('id', $id)->get()->getRow();

        // Pastikan pengguna adalah pembuat kursus
        if ($course->user_id != $userId) {
            return redirect()->to('/course')->with('error', 'Anda tidak memiliki izin untuk menghapus kursus ini.');
        }

        $this->courseData->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Kursus berhasil dihapus.');
    }
}
