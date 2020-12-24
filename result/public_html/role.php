<?php

require("connection.data-login.php");

function url_get_contents($Url){
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

# check in_array but recursively for multi dimensional array
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
		
function checkrole($cid, $ratingATC, $email, $premium){
    $rating = array(
			"2" => "447598101428043786", # S1
			"3" => "447621901519552532", # S2
			"4" => "447622078179573763", # S3
			"5" => "447622182042992641", # C1
			"7" => "447622946211758109", # C3
			"8" => "447622557827334147", # I1 and I3 ada dalam
			"10" => "447622557827334147", # satu role yang sama
			"11" => "516933981921607698", # SUP
			"12" => "515332818587353116", # ADM
		);
    
	# Seluruh member PASTI punya role pilot
	$role = array("447637402413170691");
	
	# Jika member punya rating selain pilot
	if (($ratingATC != "0") && ($ratingATC != "1")){
		# Push ke array jika cocok
		$role[] = $rating[$ratingATC];
		
		# Jika member punya rating Ins, SUP, atau ADM
		if (($ratingATC == "8") or ($ratingATC == "10") or ($ratingATC == "11") or ($ratingATC == "12")){
			$linkToCheck = "https://cert.vatsim.net/cert/vatsimnet/idstatusprat.php?cid=" . $cid;
			$data = simplexml_load_string(url_get_contents($linkToCheck));
			
			$previousrating = $data['root']['user']['PreviousRatingInt'];
			array_push($role, $rating[$previousrating]);
		}
		
		if ($ratingATC == "12"){
		    array_push($role, "516933981921607698");
		}
	}
	
	# Cek apakah punya jabatan staf
	$linkToCheck = "http://hq.vat-sea.com/api/member/" . $cid;
	$data = json_decode(url_get_contents($linkToCheck), true);
	
	# Cek apakah staf Indo vACC atau bukan
	if ($data['is_staff'] != NULL){
	    if(strpos($data['staff_position_code'], "ACCIDN") !== false){
    	    $jabatApa = explode("ACCIDN", $data['staff_position']);
    	    
    	    if (((int) $jabatApa[1] > 0) && ((int) $jabatApa[1] < 8)){
    	        // Cek apakah benar sesuai dgn data staf HQ
    	        $linkToCheck = "http://hq.vat-sea.com/api/vacc/idn/staff";
    	        $data = json_decode(url_get_contents($linkToCheck), true);
    	            
    	        foreach($data as $staf){
    	            if (($staf['cid'] == $cid)){
    	                array_push($role, "447619912265891840");
    	                break;
    	            }
    	        }
    	    } else {
    	        array_push($role, "515332818587353116");
    	    }
    	}
	}
	
	# Cek apakah ATC mentor atau bukan
	$linkToCheck = "http://api.idvacc.id/mentor.php?cid=" . $cid;
	$data = url_get_contents($linkToCheck);
	
	if($data == "TRUE"){
	    array_push($role, "460823505768808468");
	}
	
	# Cek apakah ATC active atau bukan
	$linkToCheck = "http://api.idvacc.id/atc-status.php?cid=" . $cid;
	$data = url_get_contents($linkToCheck);
	
	if($data == "TRUE"){
	    array_push($role, "447642801870733323");
	}
	
	# Cek apakah resident atau visitor
	$link_resident = "http://hq.vat-sea.com/api/vacc/idn/resident";
	$link_visitor = "http://hq.vat-sea.com/api/vacc/idn/visitor";
	
	$data_resident = json_decode(url_get_contents($link_resident), true);
	$data_visitor = json_decode(url_get_contents($link_visitor), true);
	
	if (in_array_r($cid, $data_resident)) {
	    # dia resident
	    array_push($role, "701817426827804742");
	} else if (in_array_r($cid, $data_visitor)) {
	    # dia visitor
	    array_push($role, "701817776469442712");
	}
	
	# Cek apakah dia bakal punya role premium atau ngga
	if ($premium){
	    # dia booster, lanjoott
	    array_push($role, "630284234849910796");
	}
	
	return $role;
}

function isStaff($cid){
	$linkToCheck = "http://hq.vat-sea.com/api/member/" . $cid;
	$data = json_decode(url_get_contents($linkToCheck), true);
	
	if ($data['is_staff'] != NULL){
	    return $data['staff_position_code'];
	} else {
		return FALSE;
	}
}

function nickname($nama, $cid){
	# Cek apakah staf atau bukan
	$cekStaf = isStaff($cid);
	
	if ($cekStaf != FALSE){
		$nickname = $nama . " - " . $cekStaf;
	} else {
	    $nickname = $nama . " - " . $cid;
	}
	
	if (strlen($nickname) > 32){
	    # namanya kepanjangan, discord nolak!
	    
	    $potongan_nickname = explode(" ", $nickname);
	    
	    $potongan_nickname[1] = $potongan_nickname[1][0];
	    # Note: Ini cuman berlaku kalau nickname awalnya
	    # lebih panjang daripada 32 karakter ya.
	    # Seharusnya ini ngependekin kata middle name (kalau 3 kata)
	    # atau last name (kalau 2 kata). Kalau lebih dr itu, belum
	    # diantisipasi karena ya orang Indonesia kalau lebih dari
	    # itu ya ga normal abang, hehe.
	    
	    $nickname = implode(" ", $potongan_nickname);
	    
	}
	
	return $nickname;
}

# cek apakah ada data yang masuk
if (isset($_GET['sid']) && isset($_GET['premium'])){
    # ambil sidnya
    $sid = $_GET['sid'];
    
    # buat querynya
    $query = "SELECT t1.`cid-vatsim`, t2.`email` FROM `discord` as t1 JOIN `vatsim-account` as t2 ON t1.`cid-vatsim` = t2.`cid` WHERE t1.`id-discord` = '$sid' LIMIT 1 ";

    # jalankan querynya
    if($result = mysqli_query($con, $query)){
        # cek apakah ada data
        if(mysqli_num_rows($result) > 0){
            # ada data
            $row = mysqli_fetch_array($result);
            $cid = $row['cid-vatsim'];
            $email = $row['email'];
            $premium = $_GET['premium'];

            if ($premium == "1"){
                $premium = true;
            } else {
                $premium = false;
            }

            # ambil data di API
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.vatsim.net/api/ratings/$cid/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Accept: application/json; indent=4';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            
            # Convert JSON ke array PHP
            $result = json_decode($result, true);

            # ambil name_first, name_last, rating
            $firstname = $result['name_first'];
            $lastname = $result['name_last'];
            $nama = $firstname . " " . $lastname;
            $rating = $result['rating'];

            $hasil = Array(
                "nickname" => nickname($nama, $cid),
                "role" => checkrole($cid, $rating, $email, $premium)
            );
            
            # Set header as JSON app type
            header('Content-Type: application/json');
            
            # Return JSON variable result
            print(json_encode($hasil, true));

        } else {
            # tidak ada data dalam database
            print("0");
        }
    }
}

?>