<?php
class tables_vocal_sac_tympanum {
//for user tracking information
	function trackUser($recordID,$action,$userID){
		//for user tracking information
		$user =& Dataface_AuthenticationTool::getInstance()->getLoggedInUser();		
		$user_tracking	= new Dataface_Record('user_tracking', array());
			 // We insert the default values for the record.
			//$user_tracking->setValues($defaultValues);  
			
			$user_tracking->setValues(
					array(
						'userid'=>trim($userID),
						'vocal_sac_tympanum_id' => trim($recordID),
						'action'=> $action,
						)
				);
			$user_tracking->save();
	
	}
	
	function afterInsert(&$record){
		$user =& Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
		$this->trackUser($record->strval('id'),'INSERT',$user->val('UserName'));
	}
		
	//for user tracking information
	function afterUpdate(&$record){
		$user =& Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
		$this->trackUser($record->strval('id'),'UPDATE',$user->val('UserName'));
	}
function __import__csv(&$data, $defaultValues=array()){
    
	$SEP = ',';
	// build an array of Dataface_Record objects that are to be inserted based
    // on the CSV file data.
    $records = array();
    
    // first split the CSV file into an array of rows.
    $rows = explode("\n", $data);
	
	$i=0;
	
    foreach ( $rows as $row ){
		//skip empty rows
		if (strpos($row ,$SEP) ===  false) {
			continue;
		}
		if($i == 0) {
				
			echo $row;
			$i++;
		
		continue;
		}
		
        // We iterate through the rows and parse the fields so that they can be stored in a Dataface_Record object.
        list($Id, $vocal_sac_manifestation,$vocal_sac_form,$vocal_sac_distensibility,$tympanum_covering,$tympanum_eye_ration) = str_getcsv($row, $SEP,'"') ; // explode(';', $row);
        
		$vocal_sac_tympanum	= new Dataface_Record('vocal_sac_tympanum', array());
         // We insert the default values for the record.
        $vocal_sac_tympanum->setValues($defaultValues);  
		
		$vocal_sac_tympanum->setValues(
				array(
					'id'=>trim($Id),
					'vocal_sac_manifestation'=>trim($vocal_sac_manifestation),
					'vocal_sac_form'=>trim($vocal_sac_form),
					'vocal_sac_distensibility'=>trim($vocal_sac_distensibility),
					'tympanum_covering'=>trim($tympanum_covering),
					'tympanum_eye_ration'=>trim($tympanum_eye_ration)
					)
			);
		$vocal_sac_tympanum->save();
		
		
		
		
        $records[] = $vocal_sac_tympanum ; 
    }
    
    // Now we return the array of records to be imported.
    return $records;
}

}
?>