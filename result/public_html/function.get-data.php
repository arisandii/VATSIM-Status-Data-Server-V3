<?php

# Function to get ATC data
function searchATC($callsign){
	# If requested callsign contains ,
	# then explode it to array. If not
	# do the same.
	$callsign = str_replace(' ', '', $callsign);
	$callsign = explode(",", $callsign);
	$callsign = array_filter($callsign);

	# Load the data
	$dataATC = file_get_contents("result/controllers.json");
	
	# Decode JSON data
	$dataATC = json_decode($dataATC, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATC data
	foreach ($dataATC as $callsignATC){
		# For loop over callsign
		foreach ($callsign as $callsignValue){
			# Get length of data
			$panjangData = strlen($callsignValue);
			
			# Check if data is correct
			if (substr($callsignATC["callsign"], 0,  $panjangData) == $callsignValue){
				# Save data to result variable
				//$searchResult[$callsignATC] = $valueATC;
				array_push($searchResult, $callsignATC);
			}
		}
	}

	
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

function searchATIS($callsign){
	# If requested callsign contains ,
	# then explode it to array. If not
	# do the same.
	$callsign = str_replace(' ', '', $callsign);
	$callsign = explode(",", $callsign);
	$callsign = array_filter($callsign);

	# Load the data
	$dataATIS = file_get_contents("result/atis.json");
	
	# Decode JSON data
	$dataATIS = json_decode($dataATIS, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATIS data
	foreach ($dataATIS as $callsignATIS){
		# For loop over callsign
		foreach ($callsign as $callsignValue){
			# Get length of data
			$panjangData = strlen($callsignValue);
			
			# Check if data is correct
			if (substr($callsignATIS["callsign"], 0,  $panjangData) == $callsignValue){
				# Save data to result variable
				//$searchResult[$callsignATC] = $valueATC;
				array_push($searchResult, $callsignATIS);
			}
		}
	}

	
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

# Function to get Pilot/Flightinfo data
function searchPilot($callsign){
	# Load the data
	$dataPilot = file_get_contents("result/pilots.json");
	
	# Decode JSON data
	$dataPilot = json_decode($dataPilot, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATC data
	foreach ($dataPilot as $callsignPilot){
		# If callsign correct
		if (strpos($callsignPilot["callsign"], $callsign) !== false){
			# Save data to result variable
			array_push($searchResult, $callsignPilot);
			break;
		}
	}
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

# Function to get Departure from specific ICAO
function searchDeparture($departure){
	# If requested callsign contains ,
	# then explode it to array. If not
	# do the same.
	$departure = str_replace(' ', '', $departure);
	$departure = explode(",", $departure);
	$departure = array_filter($departure);
	
	# Load the data
	$dataPilot = file_get_contents("result/pilots.json");
	
	# Decode JSON data
	$dataPilot = json_decode($dataPilot, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATC data
	foreach ($dataPilot as $callsignPilot){
		foreach ($departure as $departureValue){
			# Get length of data
			$panjangData = strlen($departureValue);
			
			if (substr($callsignPilot["flight_plan"]["departure"], 0,  $panjangData) == $departureValue){
				array_push($searchResult, $callsignPilot);
			}
		}
	}
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

# Function to get Arrival from specific ICAO
function searchArrival($arrival){
	# If requested callsign contains ,
	# then explode it to array. If not
	# do the same.
	$arrival = str_replace(' ', '', $arrival);
	$arrival = explode(",", $arrival);
	$arrival = array_filter($arrival);
	
	# Load the data
	$dataPilot = file_get_contents("result/pilots.json");
	
	# Decode JSON data
	$dataPilot = json_decode($dataPilot, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATC data
	foreach ($dataPilot as $callsignPilot){
		foreach ($arrival as $arrivalValue){
			# Get length of data
			$panjangData = strlen($arrivalValue);
			
			if (substr($callsignPilot["flight_plan"]["arrival"], 0,  $panjangData) == $arrivalValue){
				array_push($searchResult, $callsignPilot);
			}
		}
	}
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

# Function to get Arrival from specific ICAO
function searchInOut($inOut){
	# If requested callsign contains ,
	# then explode it to array. If not
	# do the same.
	$inOut = str_replace(' ', '', $inOut);
	$inOut = explode(",", $inOut);
	$inOut = array_filter($inOut);

	# Load the data
	$dataPilot = file_get_contents("result/pilots.json");
	
	# Decode JSON data
	$dataPilot = json_decode($dataPilot, true);
	
	# Array to save result
	$searchResult = array();
	
	# For loop over ATC data
	foreach ($dataPilot as $callsignPilot){
		foreach ($inOut as $inOutValue){
			$panjangData = strlen($inOutValue);
			
			if ((substr($callsignPilot["flight_plan"]["departure"], 0,  $panjangData) == $inOutValue) || (substr($callsignPilot["flight_plan"]["arrival"], 0,  $panjangData) == $inOutValue)){
				# INTERNATIONAL IN OR OUT
				array_push($searchResult, $callsignPilot);
			} else if ((substr($callsignPilot["flight_plan"]["departure"], 0,  $panjangData) == $inOutValue) && (substr($callsignPilot["flight_plan"]["arrival"], 0,  $panjangData) == $inOutValue)){
				# DOMESTIC ONLY
				array_push($searchResult, $callsignPilot);
			}
		}
	}
	# Set header as JSON app type
	header('Content-Type: application/json');
	
	# Return JSON variable result
	return(json_encode($searchResult, true));
}

?>
