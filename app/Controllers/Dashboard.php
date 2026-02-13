<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LeaveModel;
use CodeIgniter\Shield\Models\UserModel;

class Dashboard extends BaseController {

    protected $db;
    protected $session;
    protected $validation;
    protected $auth;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->auth = auth();
    }

	public function getIndex()
	{
		// Replace ion_auth logged_in check with Shield's check
		if (!$this->auth->loggedIn()) {
			return redirect()->to('/logout');
		}

        // Replace ion_auth user retrieval with Shield's user retrieval
        $user = $this->auth->user();
        $strOfficeCode = $user->OfficeCode;

		$DateFrom = $this->request->getPost('FromDate');
		$DateTo = $this->request->getPost('ToDate');

        if (empty($DateFrom)) {
            $DateFrom = date('Y-m-01');
        }
        if (empty($DateTo)) {
            $DateTo = date('Y-m-t');
        }

        try {
            $startDate = new \DateTime($DateFrom);
            $endDate = new \DateTime($DateTo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date format provided.');
        }
        // Format the dates in the desired format
        $formattedStartDate = $startDate->format('F d');
        $formattedEndDate = $endDate->format('d, Y');
        // Remove the comma after the day in the end date
        $formattedEndDate = str_replace(',', '', $formattedEndDate);
        $resultDate = $formattedStartDate . ' - ' . $formattedEndDate;

        $data['DTRCount'] = 0; 
        $data['DTRCorrectionsCount'] = 0; 
        $data['PayrollCount'] = 0; 
        $data['LeaveCount'] = 0; 

        // Mental Health (Smiley)
        $labels_Smiley = array();
        $values_Smiley = array();
        $data['labels_Smiley'] = array(); 
        $data['values_Smiley'] = array(); 
        $data['barColors_Smiley'] = ["red","brown", "orange","gray","black"];

        // Mental Health (Heart)
        $labels_Heart = array();
        $values_Heart = array();
        $data['labels_Heart'] = array(); 
        $data['values_Heart'] = array(); 
        $data['barColors_Heart'] = ["red","pink", "yellow","blue","green","gray","black"];

        // Mental Health (Gratitude)
        $labels_Gratitude = array();
        $values_Gratitude = array();
        $data['labels_Gratitude'] = array(); 
        $data['values_Gratitude'] = array(); 
        $data['barColors_Gratitude'] = [
            "red", "brown", "orange", "gray",
            "blue", "green", "purple", "yellow",
            "pink", "teal", "cyan", "magenta",
            "lime", "indigo", "salmon"
        ];

		// CSM
		$values_Smiley_CSM = array();
        $labels_Smiley_CSM = array();
		$data['labels_Smiley_CSM'] = array(); 
		$data['values_Smiley_CSM'] = array(); 
		$data['barColors_Smiley_CSM'] = ["black","gray", "brown","orange","red"];

		// CSMCC
		$labels_CSMCC = array();
		$values_CSMCC = array();
		$data['labels_CSMCC'] = array(); 
		$data['values_CSMCC'] = array(); 
		$data['barColors_CSMCC'] = ["red", "pink", "yellow", "blue", "green", "gray", "black", "orange", "purple", "cyan", "magenta", "brown", "lime"];

        if($strOfficeCode=='200'){
            $query2 = $this->db->query("call sp_Dashboard('".$DateFrom."','".$DateTo."','')");
        }else{
            $query2 = $this->db->query("call sp_Dashboard('".$DateFrom."','".$DateTo."','".$strOfficeCode."')");
        }
        $this->db->simpleQuery('DO 0'); // Clear the result set for subsequent queries

        foreach ($query2->getResultArray() as $row) {
            if($row['Category']=='DTR Corrections'){
                $data['DTRCorrectionsCount'] = $row['DataCount'];
            }elseif($row['Category']=='DTR'){
                $data['DTRCount'] = $row['DataCount'];
            }elseif($row['Category']=='Payroll'){
                $data['PayrollCount'] = $row['DataCount'];
            }elseif($row['Category']=='Leave'){
                $data['LeaveCount'] = $row['DataCount'];
            }elseif($row['Category']=='Mental Health'){
                $labels_Heart[] = $row['Desc1'];
                $values_Heart[] = $row['DataCount'];
            }elseif($row['Category']=='MentalHealth Bot'){
                $labels_Smiley[] = $row['Desc1'];
                $values_Smiley[] = $row['DataCount'];
            }elseif($row['Category']=='Gratitude'){
                $labels_Gratitude[] = $row['Desc1'];
                $values_Gratitude[] = $row['DataCount'];
            }
        }
		$data['labels_Smiley'] = $labels_Smiley;
        $data['labels_Heart'] = $labels_Heart;

		// CSM -SQD
        $secondDB = \Config\Database::connect('dbictd');
       
		$cSQL = "
		SELECT 
`tqa`.`ANSWERS`, 
COUNT(1) AS 'DataCount'
FROM 
(
    (
        `transaction` `t`
        JOIN (
            SELECT 
                `tsa`.`CSM_ID` AS `CSM_ID`, 
                `s`.`CODE` AS `CODE`, 
                CASE 
                    WHEN `tsa`.`RATE` = 1 THEN 'Strongly Disagree'
                    WHEN `tsa`.`RATE` = 2 THEN 'Disagree'
                    WHEN `tsa`.`RATE` = 3 THEN 'Neither Agree nor Disagree'
                    WHEN `tsa`.`RATE` = 4 THEN 'Agree'
                    WHEN `tsa`.`RATE` = 5 THEN 'Strongly Agree'
                    ELSE '' 
                END AS `ANSWERS`,
                `tsa`.`RATE`
            FROM 
                (`transaction_sqd_answers` `tsa`
                JOIN `sqd` `s` ON (`s`.`ID` = `tsa`.`CSM_SQD_ID`))
        ) `tqa` 
        ON (`t`.`ID` = `tqa`.`CSM_ID`)
    )
    JOIN `department` `d` ON (`d`.`ID` = `t`.`DEPARTMENT_ID`)
)
WHERE 
CAST(`DATE` AS DATE) BETWEEN '2024-12-01' AND '2024-12-31' 
AND `d`.`CODE` = '200'
GROUP BY 
`tqa`.`ANSWERS`, `tqa`.`RATE`
ORDER BY 
`tqa`.`RATE`;
";
$query2 = $secondDB->query($cSQL);

// // Check if there are more results before calling mysqli_next_result
// if (mysqli_more_results($this->db->conn_id)) {
//     mysqli_next_result($this->db->conn_id);
// }

// Process the result set
foreach ($query2->getResultArray() as $row) {
    $labels_Smiley_CSM[] = $row['ANSWERS'];
    $values_Smiley_CSM[] = $row['DataCount'];
}

		$data['values_Smiley_CSM'] = $values_Smiley_CSM; 
        $data['labels_Smiley_CSM'] = $labels_Smiley_CSM; 


		// CSM - CCQ
		$cSQL = "
		SELECT
			`trn`.`ANSWERS`,
			count( 1 ) 'DataCount' 
		FROM
			((
					`transaction` `t`
					JOIN (
					SELECT
						`tqa`.`CSM_ID` AS `CSM_ID`,
						`q`.`CODE` AS `CODE`,
						`qo`.`ENG_DESCRIPTION` AS `ANSWERS`
					FROM
						(
							`transaction_question_answers` `tqa`
						JOIN `questions` `q` ON ( `q`.`ID` = `tqa`.`CSM_QUESTION_ID` )
							JOIN questions_options qo ON ( `qo`.`ID` = `tqa`.`ANSWER` )
						) 
					) `trn` ON ( `t`.`ID` = `trn`.`CSM_ID` ))
			JOIN `department` `d` ON ( `d`.`ID` = `t`.`DEPARTMENT_ID` )) 
		WHERE cast(DATE as date) between '".$DateFrom."' and '".$DateTo."'
		and d.CODE='".$strOfficeCode."'
		group by `trn`.`ANSWERS`";
		$query2 = $secondDB->query($cSQL);

		// Check if there are more results before calling mysqli_next_result
		// if (mysqli_more_results($this->db->conn_id)) {
		// 	mysqli_next_result($this->db->conn_id);
		// }
		
		foreach ($query2->getResultArray() as $row) {
			$labels_CSMCC[] = $row['ANSWERS'];
			$values_CSMCC[] = $row['DataCount'];
		}
        $data['labels_CSMCC'] = $labels_CSMCC; 
		$data['values_CSMCC'] = $values_CSMCC; 

        $data['values_Smiley'] = $values_Smiley; 
        $data['values_Heart'] = $values_Heart; 
        $data['labels_Gratitude'] = $labels_Gratitude; 
        $data['values_Gratitude'] = $values_Gratitude; 

        if ($user->OfficeCode == '200') { 
            $SubTitle = "Data Summary of All Employees";
        } else {
            $SubTitle = "Data Summary of " . $user->Office;
        }

		$data['FromDate'] = $DateFrom;
		$data['ToDate'] = $DateTo;
		$data['ChartTitle'] = $resultDate;
		$data['Title'] = 'Dashboard';
		$data['SubTitle'] = $SubTitle;
		$data['output'] = null;
		$data['view_file'] = 'dashboard';
		$data['Dashboard'] = TRUE;
		return view('main', $data); 
	}

}
