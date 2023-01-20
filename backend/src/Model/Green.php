<?php

namespace Src\Model;

class Green {
	
	private $fileHandle;
	private $csvFile;
	
	/**
	   *	Construct
	   */
	public function __construct(){
			$this->csvFile = "data.csv";
	}
	
	public function findAll(){
		$results = [];
		$this->fileHandle = fopen($this->csvFile, "r");
		
		while( !feof($this->fileHandle) ){
			$row = (array) fgetcsv($this->fileHandle, 1024);
			array_push($results, $row);
		}
		fclose($this->fileHandle);
		
		return $results;
	}

	public function getGreen($id){
		$results = [];
		$this->fileHandle = fopen($this->csvFile, "r");
		
		while( !feof($this->fileHandle) ){
			$row = (array) fgetcsv($this->fileHandle, 1024);
			if($row[0] == $id){
				array_push($results, $row);
				break;
			}
		}
		fclose($this->fileHandle);
		
		return $results;		
	}

	public function insert($data){
		//get all greens
		$greens =  $this->findAll();
		//new green to add
		$newGreen = array((string) (end($greens)[0] + 1), $data->name,  $data->state, $data->zip, $data->amount, $data->qty, $data->item);			
		
		array_push($greens, $newGreen);
		
		$this->fileHandle = fopen($this->csvFile, "w");
		foreach( $greens as $key => $green){
			if( ($key + 1) >= count($greens)){
				// if this is a last row DON'T brakerow for it will break format
				fputs($this->fileHandle, implode(",", array_map([$this, "encodeFunc"], $green)));			
			}else{
				// there is another entery, so br/
				fputs($this->fileHandle, implode(",", array_map([$this, "encodeFunc"], $green))."\r\n");				
			}
		}
		fclose($this->fileHandle);
		
		return $this->findAll();
	}

	public function update($data, $id){
		//get all greens
		$greens =  $this->findAll();
		$greensMod = [];

		// open stream and loop over array and rewrite file
		$this->fileHandle = fopen($this->csvFile, "w");
		
		// loop over array and find/replace proper row within the array
		foreach( $greens as $key => $green){
			if($green[0] == $id ){
				//green to update
				$updatedGreen = array((string) $id, $data->name,  $data->state, $data->zip, $data->amount, $data->qty, $data->item);		
			}else{
				$updatedGreen = $green;
			}
			
			if( ($key+1) == count($greens) ){
				// if this is a last row DON'T brakerow for it will break format 
				fputs($this->fileHandle, implode(",", $updatedGreen));			
			}else{
				// there is another entery, so br/
				fputs($this->fileHandle, implode(",", $updatedGreen)."\r\n");				
			}
		}
		
		return $this->findAll();
	}

	public function delete($id){
		//get all greens
		$greens =  $this->findAll();
		$intLoop = 1;
		
		//unset($greens[$id]);

		// loop over array and remove proper row within the array
		foreach( $greens as $key => $green){
			if( $green[0] == $id ){	
		
				unset($greens[$key]);
				
				break;
			}
		}
		
		// open stream and loop over array and rewrite file
		$this->fileHandle = fopen($this->csvFile, "w");
		foreach( $greens as $key => $green){
			if( $intLoop == count($greens) ){
				// if this is a last row DON'T brakerow for it will break format
				fputs($this->fileHandle, implode(",", array_map([$this, "encodeFunc"], $green)));			
			}else{
				// there is another entery, so br/
				fputs($this->fileHandle, implode(",", array_map([$this, "encodeFunc"], $green))."\r\n");				
			}
			$intLoop++;
		}
		fclose($this->fileHandle);	
		
		
		
		
		return $this->findAll();
		//return $greens;
	}
	
	/**
	   *	Turns
	   *	"id","name","state","zip","amount","qty","item"
	   *	"1","Liquid Saffron","NY","08998","25.43","7","XCD45300"
	   *	
	   *	Into
	   *	{"id": "1", "name": "Liquid Saffron", "state": "NY". "zip": "10017", "amount": "25.43", "qty": "7", "item": "XCD45300"}
	   *	
	   *	Map Rows and Loop Through Them
	   */
	public function GreenArrToAssoc( $rows, $isSingle ) {
		if( count($rows) === 1 && !$isSingle){
			// if there are now rows besides the header don't format and return value as is
			return [];
		}
		
		$results = array();		
		// if count($rows) === 1 there ais no header and we need to add one ELSE remove & store header
		$header = ( count($rows) === 1 ) ? ["id","name","state","zip","amount","qty","item"] : array_shift($rows) ;
		
		foreach($rows as $row) {
			$results[] = array_combine($header, $row);
		}	

		//return	$results;
		return	$results;
	}
	
	/**
	   *	This funciton below helps encapsulates variables within a string so where that writting the csv files is formatted correctly 
	   */
	private function encodeFunc($value) {
		//remove any ESCAPED double quotes within string.
		$value = str_replace('\\"','"',$value);
		//then force escape these same double quotes And Any UNESCAPED Ones.
		$value = str_replace('"','\"',$value);
		//force wrap value in quotes and return
		return '"'.$value.'"';
	}

}