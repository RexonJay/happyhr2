<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table = 'office';
    protected $primaryKey = 'OfficeCode';
    protected $returnType = 'object';

    /**
     * Get offices accessible by the user
     */
    public function getOfficesByUser($user)
    {
        $db = \Config\Database::connect();

        // If NOT payroll hr or admin → limit by BatchNamePayroll
        if (
            !auth()->user()->inGroup('payroll hr') &&
            !auth()->user()->inGroup('admin')
        ) {
            return $db->query(
                "SELECT o.OfficeCode, o.OfficeName, o.ShortName
                 FROM office o
                 WHERE o.BatchNamePayroll = (
                     SELECT o2.BatchNamePayroll
                     FROM office o2
                     WHERE o2.OfficeCode = ?
                 )
                 ORDER BY o.ShortName",
                [$user->OfficeCode]
            )->getResult();
        }

        // payroll hr or admin → all offices
        return $db->query(
            "SELECT o.OfficeCode, o.OfficeName, o.ShortName
             FROM office o
             ORDER BY o.ShortName"
        )->getResult();
    }

    /**
     * Return OfficeCode list for IN() usage
     * Example output: 'OFF1','OFF2'
     */
    public function getOfficeCodeList($user)
    {
        $offices = $this->getOfficesByUser($user);

        if (empty($offices)) {
            return "'" . $user->OfficeCode . "'";
        }

        $codes = array_map(fn($o) => "'" . $o->OfficeCode . "'", $offices);

        return implode(',', $codes);
    }

    /**
     * Optional: return OfficeCode as ARRAY (recommended)
     */
    public function getOfficeCodeArray($user)
    {
        $offices = $this->getOfficesByUser($user);

        if (empty($offices)) {
            return [$user->OfficeCode];
        }

        return array_column($offices, 'OfficeCode');
    }
}