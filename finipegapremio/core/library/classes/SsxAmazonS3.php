<?php


use Aws\S3\S3Client;
require COREPATH.'../vendor/autoload.php';

class SsxAmazonS3{

	public $filename;
	public $source_filename = null;
	public $pathFolderLocal;
	public $pathFolderAmazonS3;
	public $keyname;
	public $s3;
	

	public function __construct(){

		try{
			$this->s3 = new Aws\S3\S3Client([
			    'version'     => 'latest',
			    'region'      => AWSS3_REGION,
			    'credentials' => [
			        'key'    => AWSS3_KEY,
			        'secret' => AWSS3_SECRET
			    ]
			]);		
		}catch (Aws\S3\Exception\S3Exception $e) {
			echo "There was an error on credentials.\n";	
		}
	}

	public function setFilename($filename){
		$this->filename = $filename;
	}

	public function getFilename(){
		return $this->filename;
	}

	public function setPathFolderLocal($path_local_folder){
		$this->pathFolderLocal = $path_local_folder;
	}

	public function getPathFolderLocal(){
		return $this->pathFolderLocal;
	}

	public function setPathFolderAmazonS3($path_folder_amazon_s3){
		$this->pathFolderAmazonS3 = $path_folder_amazon_s3;
	}
	public function getPathFolderAmazonS3(){
		return $this->pathFolderAmazonS3;
	}

	public function setKeyname($keyname){
		$this->keyname = $keyname;
	}

	public function getKeyname(){
		return $this->keyname;
	}

	public function setSourceFileName($source_filename){
		$this->source_filename = $source_filename;
	}

	public function getSourceFileName(){
		return $this->source_filename;
	}
	
	public function insertFile(){
		try {
			
			if(is_null(self::getSourceFileName())){
				self::setSourceFileName(self::getFileName());
			}
						
		    $result = $this->s3->putObject([
					        'Bucket' => AWSS3_BUCKET,
					        'SourceFile' => self::getPathFolderLocal().self::getSourceFileName(),
					        'Key'    => self::getPathFolderAmazonS3().basename(self::getPathFolderLocal().self::getFilename()),
					        'ACL'    => 'public-read',
					    ]);
		    return $result['ObjectURL'];
		} catch (Aws\S3\Exception\S3Exception $e) {
		    return false;
		}
	}

	public function removeFile(){
		try{
			$result = $this->s3->deleteObject(array(
			    'Bucket' => AWSS3_BUCKET,
			    'Key'    =>  self::getPathFolderAmazonS3().basename(self::getFilename())
			));  			
			return true;

		} catch (Aws\S3\Exception\S3Exception $e) {
		    return false;
		}
	}

	public function getAllFiles(){
		try{
			$objects = $this->s3->getIterator('ListObjects',[
											'Bucket'=>AWSS3_BUCKET,
											"Prefix" => self::getPathFolderAmazonS3()
											]);
			return $objects;
		}catch(Aws\S3\Exception\S3Exception $e){
			return false;
		}
	}	
	
	// FALTANDO LISTAR ITEM POR KEYNAME 

}