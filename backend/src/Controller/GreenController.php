<?php

namespace Src\Controller;

use Src\Model\Green;

class GreenController {
	private $requestMethod;
	private $actionMethod;
	private $greenId;
	
	private $greens;
	
	/**
	   *	Constructor
	   *
	   */
	public function __construct($requestMethod, $actionMethod, $greenId) {
		$this->requestMethod = $requestMethod;
		$this->actionMethod = $actionMethod;
		$this->greenId = $greenId;	

		$this->greens = new Green();
	}
	
	public function processRequest() {
       switch ($this->requestMethod) {
            case "GET":
                if ($this->greenId) {
                    $response = $this->getGreen($this->greenId);
                } else {
                    $response = $this->getAllGreens();
                };
                break;
            case "POST":
				switch($this->actionMethod ){
					case "update":
						$response = $this->updateGreenFromRequest($this->greenId);
						break;
					case "delete":
						$response = $this->deleteGreen($this->greenId);
						break;
					default:
						$response = $this->createGreenFromRequest();
				}
                break;
            default:
				print_r($this->requestMethod);
                $response = $this->notFoundResponse();
                break;
        }
        header($response["status_code_header"]);
        if ($response["body"]) {
            echo $response["body"];
        }		
	}
	
	private function getGreen( $id ){ //good
		$result = $this->greens->getGreen($id);
		
		$response["status_code_header"] = "HTTP/1.1 200 OK";
		$response["body"] = json_encode( $this->greens->GreenArrToAssoc($result, true) );
		return $response;
	}	
	
	private function getAllGreens(){ //good
		$result = $this->greens->findAll();

		$response["status_code_header"] = "HTTP/1.1 200 OK";
		$response["body"] = json_encode( $this->greens->GreenArrToAssoc($result, false) );
		return $response;
	}

	private function createGreenFromRequest(){ //good
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		
        if (! $this->validateGreen($data)) {
            return $this->unprocessableEntityResponse();
        }
        $result = $this->greens->insert($data);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($this->greens->GreenArrToAssoc($result, false));
        return $response;
	}

	private function updateGreenFromRequest($id){ //good
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		
        if ( !$this->validateGreen($data) ) {
            return $this->unprocessableEntityResponse();
        }
        $result = $this->greens->update($data, $id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($this->greens->GreenArrToAssoc($result, false));
        //$response['body'] = json_encode($result);
        return $response;
	}
	
	private function deleteGreen($id){
		$result = $this->greens->delete($id);		
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($this->greens->GreenArrToAssoc($result, false));
        //$response['body'] = json_encode($result);
        return $response;
	}

	private function validateGreen($input){
		if( !$input->name ){
			return false;
		}
		if( !$input->state ){
			return false;
		}
		if( !$input->zip ){
			return false;
		}
		if( !$input->amount ){
			return false;
		}
		if( !$input->qty ){
			return false;
		}
		if( !$input->item ){
			return false;
		}
		
		return true;
	}
	
	private function notFoundResponse()
	{
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;		
	}
	
	private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }
}
