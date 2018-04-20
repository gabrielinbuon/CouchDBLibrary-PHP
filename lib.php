<?php

// Create Database
class CouchCommands{
	
	
	protected $host = '127.0.0.1:5984/';
	protected $username = '';
	protected $password = '';
	protected $tpl = '';
	
	
	
	/*
	 * Create new database 
	 * @param: string ($dbname)
	*/ 
	public function createDatabase($dbname){
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host.$dbname);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, array(
				'Content-Type: application/json',
				'Accept: */*'
		));
		$response = curl_exec($ch);
		curl_close($ch);

		$this->getResponse($response);
	}
	
	
	/*
	 *  Create New Document
	 *  Store new document into database
	 *  
	*/
	public function createNewDocument(){
		
		$ch = curl_init();		
		$payload = json_encode($this->tpl);
		curl_setopt($ch, CURLOPT_URL, $this->host.$this->db.'/'.$this->getUID());
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, array(
			'Content-Type: application/json',
			'Accept: */*'
		));
		
		$response = curl_exec($ch);
		curl_close($ch);

		$this->getResponse($response);		
	}
	
	
	/*
	 *  Update document by unique ID
	 *  @param : string ($uid)
	 *  @param : array ($data)
	*/
	public function updateDocument($uid, $data){
		
		$ch = curl_init();
		
		$payload = json_encode($data);
		
		curl_setopt($ch, CURLOPT_URL, $this->host.$this->db.'/'.$uid);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); /* or PUT */
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: */*'
		));
		
		$response = curl_exec($ch);		
		curl_close($ch);

		$this->getResponse($response);		
	}
	
	
	/*
	 * Delete document by unique ID
	 * @param : array (unique ID/Document ID, revision ID)
	 */
	public function deleteDocument(array $arg){
		$ch = curl_init();
		
		$documentID = $arg[0];
		$revision = $arg[1];
		
		curl_setopt($ch, CURLOPT_URL, sprintf($this->host.'%s/%s?rev=%s', $this->db, $documentID, $revision));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: */*'
		));
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		$this->getResponse($response);
	}
	
	
	/*
	 *  Get UID
	 *  Unique ID is important
	 *  it is used in Unique Indexing for storing data
	*/
	public function getUID(){
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host.'_uuids');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: */*'
		));
		
		$response   = curl_exec($ch);
		$data       = json_decode($response, true);
		
		$uuid = $data['uuids'][0];	
		curl_close($ch);
		if(empty($uuid)){
                    die('UNABLE TO FETCH UID');
                    
		}else{
                    return $uuid;
                    
		}
		
	}
	
	
	/*
	 * Get documents
	 * Use it to get all documents
	*/
	public function getDocuments(){
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host.$this->db.'/_all_docs?include_do‌​cs=true');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: */*'
		));		
		
		$response = curl_exec($ch);
		curl_close($ch);		
		
		// prepare document
		$data = json_decode($response);
		if(isset($data->error)){
			die($data->error);
		}else{
			$document = [];
			$counter = count($data->rows);
			if($counter > 0){
				
                            for($i =0; $i < $counter; $i++){
                                $uid = $data->rows[$i]->id;
                                $document['data'][] = $this->getDocumentByID($uid);
                            }
                            return $document;
                                
			}else{
				return false;
                                
			}
			
		}
	}
	
	
	/*
	 * Get document by unique id 
	*/ 
	public function getDocumentByID($id){
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host.$this->db.'/'.$id);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-type: application/json',
                    'Accept: */*'
		));
		
		$response = curl_exec($ch);		
		curl_close($ch);
		$data = json_decode($response);
		
		if(isset($data->error)){
			return false;
                        
		}else{
			return $data;
                        
		}		
		
	}
	
	
	/*
	 * Template
	 * Structure your document
	 * Template allows to use multiple document structure
	 * You can extend template as per your requirement
	 * @Param : array
	*/
	public function templates($tpl){
		$uid = $this->getUID();
		$tpl['_id'] = $uid;
		$this->tpl = $tpl;
	}


	/*
         * Get CouchDB response in a better format
         * @param: json
         * @return: array (object)
         */
	public function getResponse($arg){
		$response = substr($arg, strpos($arg, '{'));
		$response = json_decode($response);

		if(isset($response->error)){
                    echo $response->error;
                    
		}else{
                    echo 'ok';
                    
		}
	}

	
	
}



$obj = new CouchCommands();