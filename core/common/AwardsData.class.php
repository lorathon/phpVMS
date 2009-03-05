<?php


class AwardsData 
{
	
	
	/**
	 * Get all awards
	 *
	 * @return mixed array of objects
	 *
	 */
	public static function GetAllAwards()
	{
		$sql = 'SELECT * FROM '.TABLE_PREFIX.'awards';
		return DB::get_results($sql);
	}
	
	
	/**
	 * Get all the details for an award
	 *
	 * @param int $awardid Award ID
	 * @return array Returns row of award
	 *
	 */
	public static function GetAwardDetail($awardid)
	{
		$awardid = intval($awardid);
		$sql = 'SELECT * FROM '.TABLE_PREFIX.'awards
					WHERE `awardid`='.$awardid;
		
		return DB::get_row($sql);
	}
	
	
	/**
	 * Get all the awards for a pilot
	 *
	 * @param int $pilotid ID of the pilot
	 * @return array Returns all the info about the pilot
	 *
	 */
	public static function GetPilotAwards($pilotid)
	{
		$pilotid = intval($pilotid);
		$sql = 'SELECT a.* 
					FROM '.TABLE_PREFIX.'awardsgranted g
					INNER JOIN '.TABLE_PREFIX.'awards a ON a.awardid = g.awardid
					WHERE g.`pilotid`='.$pilotid;
				
		return DB::get_results($sql);
	}
	
	
	/**
	 * Get the specific award of a pilot, mainly to see if they have it
	 *
	 * @param int $pilotid Pilot ID
	 * @param int $awardid Award ID
	 * @return array Row of the award
	 *
	 */
	public static function GetPilotAward($pilotid, $awardid)
	{
		
		$pilotid = intval($pilotid);
		$awardid = intval($awardid);
		
		$sql = 'SELECT a.* 
					FROM '.TABLE_PREFIX.'awardsgranted g
					INNER JOIN '.TABLE_PREFIX.'awards a ON a.awardid=g.awardid
					WHERE g.`pilotid`='.$pilotid.'
						AND g.`awardid`='.$awardid;
					  
		return DB::get_row($sql);
	}
	
	/**
	 * Add an award
	 *
	 * @param string $name Award Name
	 * @param string $descrip Description of the award
	 * @param string $image Full link to award image
	 * @return bool bool
	 *
	 */
	public static function AddAward($name, $descrip, $image)
	{
		$name = DB::escape($name);
		$descrip = DB::escape($descrip);
		$image = DB::escape($image);
		
		$sql = 'INSERT INTO '.TABLE_PREFIX."awards
						   (`name`, `descrip`, `image`)
					VALUES ('$name', '$descrip', '$image')";
		
		DB::query($sql);		
	}
	
	
	/**
	 * Edit an existing award
	 *
	 * @param int $awardid Award ID
	 * @param string $name Name of the award
	 * @param string $descrip Description of the award
	 * @param string $image Full link to award
	 * @return bool bool
	 *
	 */
	public static function EditAward($awardid, $name, $descrip, $image)
	{
		$awardid = intval($awardid);
		$name = DB::escape($name);
		$descrip = DB::escape($descrip);
		$image = DB::escape($image);
		
		$sql = 'UPDATE '.TABLE_PREFIX."awards
				  SET `name`='$name', `descrip`='$descrip', `image`='$image'
				  WHERE `awardid`=$awardid";
		
		DB::query($sql);		
	}
	
	
	/**
	 * Delete an award, also deletes any granted of it
	 *
	 * @param int $awardid Award ID
	 * @return bool bool
	 *
	 */
	public static function DeleteAward($awardid)
	{
		$sql = "DELETE FROM ".TABLE_PREFIX."awards WHERE `awardid`=$awardid";
		DB::query($sql);
		
		$sql = "DELETE FROM ".TABLE_PREFIX."awardsgranted WHERE `awardid`=$awardid";
		DB::query($sql);		
	}
	
	
	public static function AddAwardToPilot($pilotid, $awardid)
	{
		
		$sql = 'INSERT INTO '.TABLE_PREFIX."awardsgranted
					(`awardid`, `pilotid`, `dateissued`)
				 VALUES ($awardid, $pilotid, NOW())";
		
		DB::query($sql);
	}
	
}