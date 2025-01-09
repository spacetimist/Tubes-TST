<?php

namespace App\Models;

use CodeIgniter\Model;

class AssessmentModel extends Model
{
    protected $table = 'assessments'; // The name of your table
    protected $primaryKey = 'id'; // Primary key for the table

    protected $allowedFields = ['user_id', 'responses', 'score', 'created_at']; // Fields that can be inserted or updated
    protected $useTimestamps = true; // Enable automatic timestamps (created_at, updated_at)
}
