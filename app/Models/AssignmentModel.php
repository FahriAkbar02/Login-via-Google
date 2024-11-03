<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table = 'assignments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['course_id', 'title', 'description', 'due_date', 'file_path', 'google_drive_link', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}
