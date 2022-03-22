<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");
	
	header("Content-type: text/xml; charset=utf-8");
	header("Cache-control: no-store, no-cache");
	header("Expires: ".date("r"));
	
	ini_set("soap.wsdl_cache_enabled","0");
	
	class myservice {
		public function hello() {
			return Array("answer"=>"Hello");
		}
		
		public function GetSections() {
			$output=Array();
			
			while($section=DBFetchSection())
			{
				$output[]=Array(
					"id"=>$section["ID"],
					"value"=>$section["Name"]
				);
			}
			return Array("answer"=>$output);
		}
		
		public function GetVacancies($params) {
			$output=Array();
			
			while($vacancy=DBFetchVacancy(-1,(int)$params->section_id))
			{
				$output[]=Array(
					"id"=>$vacancy["ID"],
					"title"=>$vacancy["Title"],
					"date"=>$vacancy["DateTime"]
				);
			}
			return Array("answer"=>$output);
		}
		
		public function GetVacancy($params) {
					
			$vacancy=DBGetVacancy((int)$params->id);
			
			$output=Array(
				"id"=>$vacancy["ID"],
				"title"=>$vacancy["Title"],
				"content"=>$vacancy["Content"],
				"salary"=>$vacancy["Salary"],
				"experience"=>$vacancy["Experience"],
				"ismain"=>$vacancy["IsMain"],
				"ispartnership"=>$vacancy["IsPartnership"],
				"isremote"=>$vacancy["IsRemote"]
			);
			
			return Array("answer"=>$output);
		}
	}
	
	$server=new SoapServer("http://{$_SERVER['HTTP_HOST']}/soapapi/job.wsdl.php");
	$server->setClass("myservice");
	$server->handle();