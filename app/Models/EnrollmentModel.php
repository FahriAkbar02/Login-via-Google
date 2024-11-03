<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'role', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    public function isUserEnrollment($userId, $courseId)
    {
        return $this->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->countAllResults() > 0;
    }

    // Fungsi untuk menambahkan peserta baru ke dalam suatu kursus
    public function addEnrollment($userId, $courseId)
    {
        return $this->insert(['user_id' => $userId, 'course_id' => $courseId]);
    }
    public function getStudentsByCourseId($courseId)
    {
        return $this->where('course_id', $courseId)
            ->where('role', 'student')
            ->findAll();
    }
}
