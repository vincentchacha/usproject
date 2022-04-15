<?php
namespace App\Controllers;
\Config\Database::connect();

header('Access-Control-Allow-Origin: *'); 

class Api extends App_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();

  
    }
    
    public function signupfl() {
   
       $password=password_hash($_GET['password'], PASSWORD_DEFAULT);
            //$user_data["created_at"] = get_current_utc_time();

        $phone = $_GET['phone'];
       //$referralcode = $this->input->post('agentid');
        $email = $_GET['email'];
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
       $location= $_GET['location'];
      $data = array(
            
             "address" => $location,
            "phone" => $phone,
            "currency_symbol" => "KES",
          //  "created_at" =>   get_current_utc_time()  ,
            "is_lead" => "0",
            "owner_id" => "1",
            "country" => $location,
             "company_name" => $firstname." ".$lastname,
        );
        $db1 = db_connect('default'); 
$builder = $db1->table('clients');
$builder->insert($data);
$userid=$db1->insertID();
        $table = "users";
        $code = rand(1111, 9999);
        $data = array(
            
            "password" => $password,
             "phone" => $phone,
            "is_admin" => "0",
            "deleted" => "0",
            "user_type" => "client",
            "created_at" =>   get_current_utc_time()  ,
            "role_id" => "0",
            "client_id" => "$userid",
            "email" => $email,
             "first_name" => $firstname,
              "last_name" => $lastname
        );
        $db = db_connect('default'); 
$builder = $db->table('users');


$builder->insert($data);
//echo $db->insertID();
       $this->jsonResponse($data, "user", TRUE, "registered  successfully");
          
 }
 //
 
 
        
    
     public  function loginfl()
	{
	    //$token = $this->generateToke();
        $email = $_GET['phone'];
        $pass =$_GET['password'];
    //  $user_info->password === md5($password)
  $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('users');
   $result = $builder->getWhere(array('phone' => $email, 'deleted' => 0));

        if (count($result->getResult()) !== 1) {
$this->setError("Not Found");
}
//


else {
                 $user_info = $result->getRow();

//if(password_verify($pass, $user_info->password)) {
    
$this->jsonResponse($user_info, "user", TRUE);
             
            // }else{
                
            //     $this->setError("wrong password");

            // }
               }      
    } 
    
    
    
      public function createmilestone(){
 
 $data = array(
            "title" => $_GET['title'],
            "description" =>  $_GET['description'],
            "client_id" =>  $_GET['project_id'],
            "due_date" =>  get_current_utc_time(),
            "butget" =>  $_GET['budget'],
            "status" => "pending",
        );
 $db = db_connect('default'); 
$builder = $db->table('milestones');


$results=$builder->insert($data);
          
     if(!$results) {
                $this->setError("milestone not created");

//$this->jsonResponse($results, "user", TRUE,"created successfully");
             
            }else{
                  $this->jsonResponse($results, "user", TRUE);
  

            }}
        
     public function createproject(){
 
 $data = array(
            "title" => $_GET['title'],
            "description" =>  $_GET['description'],
            "client_id" =>  $_GET['client_id'],
            "start_date" =>  get_current_utc_time(),
            //"deadline" =>  $_GET['deadline'],
            "price" =>  $_GET['price'],
             "county" =>  $_GET['region'],
              "location" =>  $_GET['location'],
            "created_date" =>  get_current_utc_time(),
            "created_by" =>  "Admin",
            "labels" =>  "not started",
            "status" => "pending",
        );
 $db = db_connect('default'); 
$builder = $db->table('projects');


$results=$builder->insert($data);
 $data2 = array(
            "project_id" => $db->insertID(),
            "user_id" =>  "23",
            "is_leader" =>  "0",
           
        );

$db = db_connect('default'); 
$builder = $db->table('project_members');


$results2=$builder->insert($data2);
$data3 = array(
            "project_id" => $db->insertID(),
            "user_id" =>  "22",
            "is_leader" =>  "0",
           
        );

$db = db_connect('default'); 
$builder = $db->table('project_members'); 


$results2=$builder->insert($data3);
if(!$results) {
                $this->setError("project not created");

//$this->jsonResponse($results, "user", TRUE,"created successfully");
             
            }else{
                  $this->jsonResponse($results, "user", TRUE);
  

            }



// 	$data['transid']=$this->db->insert_id();    

 		         
     
// 		$listing[]=$data;
				
	
// 	echo json_encode($listing, JSON_UNESCAPED_SLASHES);   
	
    }
    public function discover_place(){
        header("Access-Control-Allow-Origin: *");
    $db      = \Config\Database::connect();

$builder = $db->table('regions');

$query   = $builder->get();  
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    //		$this->load->model('Trips_model');
$cityname = "Nairobi";
	   //		$this->load->model('Trips_model');
$cityname = "Nairobi";
  
		foreach($query->getResult() as $row)
		{
			$data['id']   = $row->id;
			//$data['city_id']  = $row->city_id;
			$data['place_name']  = $row->Region;
		//	$data['quote']   = $row->quote;
		//	$data['short_desc']  = $row->short_desc;
		//	$data['long_desc']  = $row->long_desc;
			//$data['image_name'] = $row->image_name;
		//	$data['is_featured'] = $row->is_featured;
			$inner[]  = $data;
		}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);
//
	
}
public function viewneighbourhood(){
    header("Access-Control-Allow-Origin: *");
        $db      = \Config\Database::connect();

$builder = $db->table('constituency');
	//$query  = $this->db->where('county_id',$cityname)->get('Locations');

    //		$this->load->model('Trips_model');
$cityname = $_GET['regionid'];
	$query = $builder->getWhere(['county_id' => $cityname]);
		foreach($query->getResult() as $row)
{
			$data['id']   = $row->const_id;
			$data['place_name']  = $row->const_name."-".$row->ward_name." ward";
	
			$inner[]  = $data;
}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

	
}
public function viewagents(){
    header("Access-Control-Allow-Origin: *");

 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    //		$this->load->model('Trips_model');
$cityname = $_GET['regionid'];
	//$query = $this->db->query('select * from Locations ORDER BY Location ASC');
//	$this->db->where('county_id',$cityname);
	$query  = $this->db->where('location',$cityname)->get('agents');
	if($query->num_rows() !=0)
	{
		foreach($query->result() as $row)
		{
			$data['id']   = $row->id;
			$data['place_name']  = $row->Location;
	
			$inner[]  = $data;
		}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

	}
}
public function getuserprojects(){
    //$projectid=$_GET['userid'];
     $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('projects');
   $result = $builder->getWhere(array('client_id' => $_GET['userid'], 'deleted' => 0));
	foreach($result->getResult() as $row)
{
    	$data['id']   = $row->id;
			$data['project_name']  = $row->title;
				$data['status']  = $row->status;
				$data['image_url']  = $row->image_url;
				$data['amount']  = $row->price;
				$data['location']  = $row->county." ".$row->location;

			$inner[]  = $data;
}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

}
public function signprojectcontract(){
    //$projectid=$_GET['userid'];
     $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('contracts');
   $result = $builder->getWhere(array('id' => $_GET['contractid'], 'deleted' => 0));
  //$contract_data = array("status" => $status);
                    //if ($status == "accepted") {
                    $contract_data = array("status" => "accepted");
                        $contract_data["accepted_by"] =  $_GET['client_id'];

                    $contract_id = $this->Contracts_model->ci_save($contract_data, $_GET['contractid']);
			$inner[]  = $contract_data;
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

}

public function getprojectdocuments(){
    //$projectid=$_GET['userid'];
     $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('contracts');
   $result = $builder->getWhere(array('project_id' => $_GET['project_id'], 'deleted' => 0));
	foreach($result->getResult() as $row)
{
    	$data['id']   = $row->id;
			$data['name']  = $row->title;
				$data['status']  = $row->status;
				$data['due_date']  = $row->valid_until;
				$data['view_url']  = "https://dashboard.zipkash.com/index.php/contract/preview/2/nhfplLjgxy";

			$inner[]  = $data;
}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

}
            public function sendotp(){
            $code = rand(111111, 999999);
               // $message = "Your PPO PROJECT verification code is : $code ";
        $message = "Your PPO Project App verification code is : $code ";

$text = urlencode($message);
// $API_KEY = "eba318d7a72f88fc879e00347839f097-a2a96355-b883-4fab-bddc-d00d6abddd02";
            $phone = $_GET['phone'];
//             if ($this->users_model->phone_exists($phone)){
//       $data['message']="phoneexist";
// $data['code']=123456;
          
                
//             }else{

 // $phone = $this->input->get('phone');
                 //  $code = rand(111111, 999999);


     //   $message = "Your PPO Project App verification code is : $code ";
$curl = curl_init();
 

$BASE_URL = "https://pwqvyv.api.infobip.com";
$API_KEY = "App eba318d7a72f88fc879e00347839f097-a2a96355-b883-4fab-bddc-d00d6abddd02";

$SENDER = "InfoSMS";
$RECIPIENT = $phone;
$MESSAGE_TEXT = $message;
 
$MEDIA_TYPE = "application/json";
 
curl_setopt_array($curl, array(
    CURLOPT_URL => $BASE_URL . '/sms/2/text/advanced',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
 
    CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $API_KEY,
        'Content-Type: ' . $MEDIA_TYPE,
        'Accept: ' . $MEDIA_TYPE
    ),
 
    CURLOPT_POSTFIELDS =>'{"messages":[{"from":"' . $SENDER . '","destinations":[{"to":"' . $RECIPIENT . '"}],"text":"' . $MESSAGE_TEXT . '"}]}',
));
 
$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
      $data['message']="code";
$data['code']=$code;

    //     }
          $listing[]=$data;
	echo json_encode($listing, JSON_UNESCAPED_SLASHES);   

//	echo json_encode($response, JSON_UNESCAPED_SLASHES);   
    }


public function getprojectmilestones(){
    //$projectid=$_GET['userid'];
     $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('milestones');
   $result = $builder->getWhere(array('project_id' => $_GET['project_id'], 'deleted' => 0));
	foreach($result->getResult() as $row)
{
         	$data['id']   = $row->id;
			$data['name']  = $row->title;
				$data['status']  = $row->status;
				$data['due_date']  = $row->due_date;
				$data['budget']  = $row->budget;

		
			$inner[]  = $data;
}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

}

public function getprojectdetails(){
    //$projectid=$_GET['userid'];
     $db = db_connect('default'); 
//$builder = $db->table('users');

$builder = $db->table('projects');
   $result = $builder->getWhere(array('id' => $_GET['projectid'], 'deleted' => 0));
	foreach($result->getResult() as $row)
{
    	$data['id']   = $row->id;
			$data['project_name']  = $row->title;
				$data['status']  = $row->status;
				$data['image_url']  = $row->image_url;
				$data['amount']  = $row->price;
				$data['location']  = $row->county." ".$row->location;

			$inner[]  = $data;
}
	//	echo json_encode($inner);
			echo json_encode($inner, JSON_UNESCAPED_SLASHES);

}

    public function checkprojectstatus(){
        $data['status']=$this->db->where('id',$_GET['projectid'])->get('projects')->row('status'); 
$listing[]=$data;
				
	
	echo json_encode($listing, JSON_UNESCAPED_SLASHES);   
	
    }
    
    
     function setError($msg) {
        $this->jsonResponse("", "data", FALSE, $msg);
    }

    function jsonResponse($data, $type, $success = TRUE, $message = "", $split = FALSE) {
        $res = array("error" => !$success, "msg" => $message);
        if ($split === TRUE) {
            $res = array_merge($res, $data);
        } else {
            $res[$type] = $data;
        }
        echo json_encode($res);
    }
    
    
    
}