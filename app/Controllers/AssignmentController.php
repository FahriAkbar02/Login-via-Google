<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AssignmentController extends Controller
{
    protected $db;
    protected $assignments;
    protected $users;
    protected $courseData;
    protected $enrollments;
    protected $email;

    public function __construct()
    {
        $this->email = \Config\Services::email();
        $this->db = \Config\Database::connect();
        $this->users = $this->db->table('users');
        $this->courseData = $this->db->table('courses');
        $this->enrollments = $this->db->table('enrollments');
        $this->assignments = $this->db->table('assignments');
    }

    public function index($id = null)
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();

        if ($id) {
            $course = $this->courseData->where('id', $id)->get()->getRow();
        }

        $userCourses = $this->courseData->where('user_id', $userId)->get()->getResultArray();

        $this->enrollments->select('courses.*, users.username as username, users.profile as profile');
        $this->enrollments->join('courses', 'courses.id = enrollments.course_id');
        $this->enrollments->join('users', 'users.id = courses.user_id');
        $this->enrollments->where('enrollments.user_id', $userId);
        $joinedCourses = $this->enrollments->get()->getResultArray();

        return view('daftar/assignment', ['userCourses' => $userCourses, 'joinedCourses' => $joinedCourses, 'userData' => $userData, 'course' => $course]);
    }

    public function create($courseId)
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();
        $courses = $this->courseData->where('id', $courseId)->get()->getRow();
        if ($userData->id !== $courses->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }
        $courseSubmissions = $this->assignments->where('course_id', $courseId)->get()->getResultArray();
        $participantIds = $this->enrollments->where('course_id', $courseId)->get()->getResult();
        $enrolledUsers = [];
        foreach ($participantIds as $participant) {
            $participantUserId = $participant->user_id;
            $participantUserData = $this->users->where('id', $participantUserId)->get()->getRow();
            if ($participantUserData) {
                $enrolledUsers[] = $participantUserData;
            }
        }

        // Kirimkan data kursus, data pengguna, data submission, dan data pengguna yang terdaftar ke tampilan untuk ditampilkan
        return view('submissions/assignment_create', ['courses' => $courses, 'userData' => $userData, 'courseSubmissions' => $courseSubmissions, 'enrolledUsers' => $enrolledUsers]);
    }

    public function store()
    {
        $courseId = $this->request->getPost('course_id');
        $userId = session()->get('google_id');
        $userData = $this->users->where('id', $userId)->get()->getRow();
        $data = [
            'course_id' => $courseId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'file_path' => '',
            'google_drive_link' => $this->request->getPost('google_drive_link'),
        ];
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            $data['file_path'] = 'uploads/' . $newName;
        }
        $this->assignments->insert($data);
        $assignmentId = $this->db->insertID();
        $this->createNotification($userId, $courseId, 'Pemberitahuan !!', $assignmentId);
        $enrolledUsers = $this->getEnrolledUsers($courseId);

        $course = $this->courseData->where('id', $courseId)->get()->getRow();
        foreach ($enrolledUsers as $user) {
            $message = '
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="' . base_url() . '/img/CH1.png" class="w-px-100 h-auto rounded-circle" alt="Logo Kelas">
            </div>
            <div class="col text-right">
                <a href="#" target="_blank" style="text-decoration:none;"></a>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card border-0">
                    <div class="card-body">
                        <h2 class="card-title">' . $course->name . ', Time:' . $course->schedule . ', ' . $course->room . ' <br>
                      </h2> <span> Tenggat : ' . $data['due_date'] . '</span>
                        <h3 class="card-text">
                            ' . $data['title'] . '</h3>
                            <br>
                            <br>
                            <p>' . $data['description'] . '<br>';

            if (!empty($data['file_path'])) {
                $message .= 'File: <a href="' . base_url($data['file_path']) . '">' . basename($data['file_path']) . '</a><br>';
            }

            $message .= 'Link : ' . $data['google_drive_link'] . '
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-white mt-4">
        <div class="container">
            <div class="row py-3">
                <div class="col text-center">
                    <p>&copy; 2024 Guuglu Classhome</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
';

            $this->sendEmailNotification($userData->email, 'New Assignment Notification', $message, $user->email);
        }


        return redirect()->back()->with('success', 'Tugas telah berhasil dibuat.');
    }

    protected function sendEmailNotification($fromEmail, $subject, $message, $toEmail)
    {
        $emailService = \Config\Services::email();

        $emailService->setTo($toEmail); // Set alamat email penerima
        $emailService->setFrom($fromEmail, 'Guuglu-ClassHome');
        $emailService->setSubject($subject);
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            return false;
        } else {
            return true;
        }
    }


    protected function createNotification($userId, $courseId, $message, $assignmentId)
    {
        $notificationData = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'message' => $message,
            'assignment_id' => $assignmentId,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('notifications')->insert($notificationData);
    }
    protected function getEnrolledUsers($courseId)
    {
        $students = $this->db->table('enrollments')
            ->select('enrollments.user_id, users.email')
            ->join('users', 'users.id = enrollments.user_id')
            ->where('enrollments.course_id', $courseId)
            ->get()
            ->getResult();

        return $students;
    }


    public function edit($assignmentId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();

        $assignment = $this->assignments->where('id', $assignmentId)->get()->getRow();

        $courses = $this->courseData->where('id', $assignment->course_id)->get()->getRow();
        if ($userData->role !== 'guru' || $courses->user_id !== $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        return view('submissions/edit_assignment', ['assignment' => $assignment, 'userData' => $userData, 'courses' => $courses]);
    }

    public function update($assignmentId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();

        $assignment = $this->assignments->where('id', $assignmentId)->get()->getRow();

        $courses = $this->courseData->where('id', $assignment->course_id)->get()->getRow();
        if ($userData->role !== 'guru' || $courses->user_id !== $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'google_drive_link' => $this->request->getPost('google_drive_link'),
        ];

        $this->assignments->where('id', $assignmentId)->update($data);

        return redirect()->to('/submissions/create_submissions/' . $assignmentId)->with('success', 'Tugas telah berhasil diperbarui.');
    }


    public function delete($assignmentId)
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userData = $this->users->where('id', $userId)->get()->getRow();

        // Mengambil informasi tugas berdasarkan ID
        $assignment = $this->assignments->where('id', $assignmentId)->get()->getRow();

        $course = $this->courseData->where('id', $assignment->course_id)->get()->getRow();
        if ($course->user_id !== $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini');
        }

        $courseId = $assignment->course_id;

        $this->assignments->where('id', $assignmentId)->delete();

        $this->deleteNotification($courseId, $assignmentId);

        return redirect()->to('/course/detail_course/' . $courseId)->with('success', 'Tugas telah berhasil dihapus.');
    }

    protected function deleteNotification($courseId, $assignmentId)
    {
        $this->db->table('notifications')
            ->where('course_id', $courseId)
            ->where('assignment_id', $assignmentId)
            ->delete();
    }
}
