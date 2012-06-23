<?php

class FW_Gateway_Amf
{
    public function getFlashData( )
    {
    	$lastGame = models_GameMapper::getLastMonolit();
    	
    	$nextGame = models_GameMapper::getNextMonolit();
    	
    	$res = array(
    	
    		'lastMatch' => array(
    			'team1' => $lastGame->teamTitle1,
    			'team2' => $lastGame->teamTitle2,
    			'goal1' => $lastGame->goals1,
    			'goal2' => $lastGame->goals2,
    		),
    		
    		'nextMatch' =>  array(
    			'teams' => $nextGame->teamTitle1.' : '.$nextGame->teamTitle2,
    			'date'	=> substr(FW_Date::convert($nextGame->date, FW_Date::MYSQL_DATETIME, FW_Date::SITE_DATE),0, 5),
    		 	'time'  => substr(FW_Date::convert($nextGame->date, FW_Date::MYSQL_DATETIME, FW_Date::SITE_TIME),0, 5),
    			'place' => $nextGame->place?$nextGame->place:'Спорткомплекс',
    		
    		)
    		
    		
    	
    	);
    	
    	return $res;
    }
}