<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SubmissionsController extends Controller
{
    protected $db;
    protected $assignments;
    protected $users;
    protected $courseData;
    protected $submissions;
    protected $enrollments;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = $this->db->table('users');
        $this->courseData = $this->db->table('courses');
        $this->enrollments = $this->db->table('enrollments');
        $this->assignments = $this->db->table('assignments');
        $this->submissions = $this->db->table('submissions');
    }

    public function create($assignmentId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data assignment berdasarkan assignment_id
        $assignment = $this->assignments->where('id', $assignmentId)->get()->getRow();

        // Jika assignment tidak ditemukan, redirect ke halaman sebelumnya
        if (!$assignment) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
        }

        // Ambil data kursus yang diajar oleh pengguna
        $course = $this->courseData->where('id', $assignment->course_id)->get()->getRow();

        // Ambil data submission untuk assignment ini oleh pengguna yang sedang login
        $submission = $this->submissions->where('assignment_id', $assignmentId)
            ->where('user_id', $userId)
            ->get()->getRow();

        // Ambil informasi pengguna yang sedang login
        $userData = $this->users->where('id', $userId)->get()->getRow();

        // Periksa apakah pengguna memiliki peran guru
        $userRole = $this->users->where('id', $userId)->get()->getRow()->role;

        // Ambil data submission berdasarkan assignment beserta informasi nama pengguna
        $courseSubmissions = $this->db->table('submissions')
            ->select('submissions.*, users.username')
            ->join('users', 'users.id = submissions.user_id')
            ->where('submissions.assignment_id', $assignmentId)
            ->get()->getResultArray();

        // Kirimkan data assignment, data submission, dan data pengguna ke tampilan untuk ditampilkan
        return view('submissions/submissions_Tugas', [
            'courseSubmissions' => $courseSubmissions,
            'assignment' => $assignment,
            'submission' => $submission,
            'userData' => $userData,
            'userId' => $userId,
            'course' => $course,
            'userRole' => $userRole // Kirimkan role pengguna ke view
        ]);
    }

    public function store()
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data yang dikirimkan dari formulir
        $data = [
            'assignment_id' => $this->request->getPost('assignment_id'),
            'user_id' => $userId,
            'submission_date' => date('Y-m-d H:i:s'), // Tambahkan tanggal dan waktu submission
            'file_path' => '', // Tambahkan kolom file_path dengan nilai awal kosong
        ];

        // Cek apakah ada file yang diunggah
        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate nama file unik
            $newName = $file->getRandomName();

            // Pindahkan file ke direktori yang ditentukan
            $file->move(ROOTPATH . 'public/uploads', $newName);

            // Simpan path file ke dalam data
            $data['file_path'] = 'uploads/' . $newName;
        }

        // Simpan data submission ke dalam database
        $this->submissions->insert($data);

        // Redirect ke halaman lain atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Tugas berhasil di Kirim.');
    }

    public function edit($submissionId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data submission yang akan diedit
        $submission = $this->submissions->where('id', $submissionId)->get()->getRow();

        // Periksa apakah submission ditemukan
        if (!$submission) {
            return redirect()->back()->with('error', 'Submission tidak ditemukan.');
        }

        // Pastikan submission yang diedit adalah milik pengguna yang sedang login
        if ($submission->user_id !== $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        // Ambil data assignment berdasarkan assignment_id
        $assignment = $this->assignments->where('id', $submission->assignment_id)->get()->getRow();

        // Jika assignment tidak ditemukan, redirect ke halaman sebelumnya
        if (!$assignment) {
            return redirect()->back()->with('error', 'Tugas tidak ditemukan.');
        }

        // Ambil data kursus yang diajar oleh pengguna
        $course = $this->courseData->where('id', $assignment->course_id)->get()->getRow();

        // Ambil informasi pengguna yang sedang login
        $userData = $this->users->where('id', $userId)->get()->getRow();

        // Periksa apakah pengguna memiliki peran guru
        $userRole = $this->users->where('id', $userId)->get()->getRow()->role;

        // Kirim data submission ke view untuk diedit
        return view('submissions/edit_submission', [
            'submission' => $submission,
            'assignment' => $assignment,
            'userData' => $userData,
            'userId' => $userId,
            'course' => $course,
            'userRole' => $userRole
        ]);
    }

    public function update($submissionId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data submission yang akan diupdate
        $submission = $this->submissions->where('id', $submissionId)->get()->getRow();

        // Periksa apakah submission ditemukan
        if (!$submission) {
            return redirect()->back()->with('error', 'Submission tidak ditemukan.');
        }

        // Pastikan submission yang diedit adalah milik pengguna yang sedang login
        if ($submission->user_id !== $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        // Ambil data yang dikirimkan dari formulir
        $data = [
            'file_path' => '', // Tambahkan kolom file_path dengan nilai awal kosong
        ];

        // Cek apakah ada file yang diunggah
        $file = $this->request->getFile('file_path');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate nama file unik
            $newName = $file->getRandomName();

            // Pindahkan file ke direktori yang ditentukan
            $file->move(ROOTPATH . 'public/uploads', $newName);

            // Simpan path file ke dalam data
            $data['file_path'] = 'uploads/' . $newName;
        }

        // Update data submission ke dalam database
        $this->submissions->where('id', $submissionId)->update($data);

        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Submission berhasil diupdate.');
    }

    public function delete($submissionId)
    {
        // Pastikan user sudah login
        $userId = session()->get('google_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Periksa apakah pengguna memiliki peran siswa
        $userRole = $this->users->where('id', $userId)->get()->getRow()->role;
        if ($userRole !== 'siswa') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki izin untuk mengakses ini.');
        }

        // Hapus submission dari database
        $this->submissions->where('id', $submissionId)->where('user_id', $userId)->delete();

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Submission berhasil dihapus.');
    }
}
