<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class NotificationController extends Controller
{
    protected $db;
    protected $users;
    protected $notifications;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = $this->db->table('users');
        $this->notifications = $this->db->table('notifications');
    }

    public function index()
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data notifikasi untuk pengguna tertentu
        $notifications = $this->notifications
            ->select('notifications.*, courses.name as course_name, assignments.title as assignment_title')
            ->join('courses', 'notifications.course_id = courses.id')
            ->join('enrollments', 'courses.id = enrollments.course_id')
            ->join('assignments', 'notifications.assignment_id = assignments.id') // Gabungkan dengan tabel assignments
            ->where('enrollments.user_id', $userId)
            ->where('notifications.read_at IS NULL')
            ->orderBy('notifications.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $userData = $this->users->where('id', $userId)->get()->getRow();

        return view('notifications', ['notifications' => $notifications, 'userData' => $userData]);
    }


    public function createAnnouncementNotification($courseId, $announcement)
    {
        $students = $this->db->table('enrollments')
            ->select('user_id')
            ->where('course_id', $courseId)
            ->get()
            ->getResultArray();

        foreach ($students as $student) {
            $data = [
                'user_id' => $student['user_id'],
                'course_id' => $courseId,
                'type' => 'announcement',
                'message' => 'Pengumuman baru: ' . $announcement,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->notifications->insert($data);
        }
    }



    public function markAsRead($notificationId)
    {
        $this->notifications
            ->where('id', $notificationId)
            ->update(['read_at' => date('Y-m-d H:i:s')]);
    }
    public function listAssign($userId)
    {
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $assignments = $this->db->table('assignments')
            ->select('assignments.*, courses.name as course_name')
            ->join('courses', 'assignments.course_id = courses.id')
            ->join('enrollments', 'courses.id = enrollments.course_id')
            ->where('enrollments.user_id', $userId)
            ->get()
            ->getResultArray();

        $userData = $this->db->table('users')->where('id', $userId)->get()->getRow();

        return view('daftar_tugas', ['assignments' => $assignments, 'userData' => $userData]);
    }
}
