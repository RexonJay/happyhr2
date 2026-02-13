<?php

namespace App\Models;

use CodeIgniter\Model;

class ErrorLogModel extends Model
{
    protected $table      = 'tbl_error_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'module',
        'error_message',
        'file',
        'line',
        'user_id',
        'ip_address',
        'created_at'
    ];

    protected $useTimestamps = false;

    public function logError($module, \Throwable $e, $userId = null, $ip = null)
    {
        return $this->insert([
            'module'        => $module,
            'error_message' => $e->getMessage(),
            'file'          => $e->getFile(),
            'line'          => $e->getLine(),
            'user_id'       => $userId,
            'ip_address'    => $ip,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}