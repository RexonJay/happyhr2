<!-- <?php

namespace App\Controllers;

class Standing extends BaseController
{
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


	public function index(){

		$numberofvoters = 0;
		$query = $this->db->query("select count(1) 'numberofvoters' from users where ecode<>'10000'");
		if ($query->getNumRows() > 0) {
		    $numberofvoters = $query->getRow()->numberofvoters;
		}

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='1'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordPresident'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='2'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordVicePresident'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='3'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordSecretary'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='4'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordTreasurer'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='5'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordAuditor'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='6'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordBusinessManager'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='7'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordPublicInformationOfficer'] = $query->getResult();

		$query = $this->db->query("select * from (
				select tvn.Candidate
				,(select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1) 'NumberOfVotes'
				,((select count(1) from tblvote tv where tv.votetrnid=tvn.id and ifnull(tv.IsActive,0)=1)/".$numberofvoters.")*100 'NumberOfVotesPercent'
				,CandidateImage
				, ifnull(Partylist,'') Partylist
				from tblvotetrn tvn  
				where tvn.votemstid='8'
				) as x order by NumberOfVotes desc, Candidate asc
				");
		$data['recordBoardOfTrustees'] = $query->getResult();


		return view('standing',$data);
	}

} -->
