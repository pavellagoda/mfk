<?php

/**
 * @author valery
 */

class FW_Table
{

    public static function getTable($idTournament, $idTour) {
        return self::_getTourTable($idTournament, $idTour);
    }

	protected static function _getTourTable($idTournament, $idTour) {

	    $tours = models_TourMapper::getAllByTournament($idTournament);

	    $gamesRaw = models_GameMapper::findAllByTournament($idTournament);

	    $games = array();

	    foreach ($gamesRaw as $game) {
	        /* @var $game models_Game */
	        if ($game->idTour <= $idTour) {
	            $games[] = $game;
	        }
	    }

	    $results = array();
	    foreach ($games as $game) {
	        /* @var $game models_Game */
	        $t1 = $game->idTeam1;
	        $t2 = $game->idTeam2;

	        if (!array_key_exists($t1, $results)) {
	            $results[$t1] = self::_initTeam($t1);
	        }
	        if (!array_key_exists($t2, $results)) {
	            $results[$t2] = self::_initTeam($t2);
	        }

	        if (!$game->completed) {
	            continue;
	        }

	        $results[$t1]['games']++;
	        $results[$t2]['games']++;
	        if ($game->goals1 > $game->goals2) {
	            $results[$t1]['win']++;
	            $results[$t2]['fail']++;
	            $results[$t1]['score'] += 3;
	        } elseif ($game->goals1 < $game->goals2) {
	            $results[$t1]['fail']++;
	            $results[$t2]['win']++;
	            $results[$t2]['score'] += 3;
	        } else {
	            $results[$t1]['draw']++;
	            $results[$t2]['draw']++;
	            $results[$t1]['score'] += 1;
	            $results[$t2]['score'] += 1;
	        }
            $results[$t1]['goals'] += $game->goals1;
            $results[$t2]['goals_fail'] += $game->goals1;
            $results[$t2]['goals'] += $game->goals2;
            $results[$t1]['goals_fail'] += $game->goals2;
	    }

	    FW_TeamsComparator::init($results, $games);

	    uasort($results, 'FW_TeamsComparator::compare');

	    $teams = models_TeamMapper::getAll();

	    foreach ($teams as $team) {
	        if (array_key_exists($team->id, $results)) {
	            $results[$team->id]['title'] = $team->title;
	            $results[$team->id]['club_id'] = $team->club_id;
	        }
	    }

        return $results;

	}

	protected static function _initTeam($id) {
	    return array (
	        'id' => $id,
            'games' => 0,
            'win' => 0,
            'draw' => 0,
            'fail' => 0,
            'goals' => 0,
            'goals_fail' => 0,
            'score' => 0
        );
	}

}