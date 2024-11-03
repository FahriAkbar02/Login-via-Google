<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'schedule', 'room', 'user_id', 'participants', 'created_at', 'updated_at', 'deleted_at']; // Sesuaikan dengan kolom-kolom yang ada pada tabel courses
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    public function isUserJoined($courseId, $userId)
    {
        $builder = $this->db->table('courses');
        $builder->where('course_id', $courseId);
        $builder->where('user_id', $userId);
        $result = $builder->get()->getRow();
        return $result ? true : false;
    }

    public function addUserToCourse($courseId, $userId)
    {
        $data = [
            'course_id' => $courseId,
            'user_id' => $userId
        ];
        $this->db->table('courses')->insert($data);
    }

    public function getUserId($courseId)
    {
        $course = $this->find($courseId);
        if ($course) {
            return $course['user_id'];
        }
        return null;
    }
}
