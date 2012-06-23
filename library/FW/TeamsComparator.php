<?php

/**
 * @author valery
 */

class FW_TeamsComparator {
    public static $list;
    public static $games;

    public static function init($list, $games) {
        self::$list = $list;
        self::$games = $games;
    }

    function compareScore($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        if ($a['score'] > $b['score']) {
            return -1;
        }
        if ($a['score'] < $b['score']) {
            return 1;
        }
        return 0;
    }

    function compareMeets ($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        $aw = $bw = 0;
        foreach (self::$games as $game) {
            if ($game->idTeam1 == $ida && $game->idTeam2 == $idb) {
                if ($game->goals1 > $game->goals2) {
                    $aw ++;
                } elseif ($game->goals1 < $game->goals2) {
                    $bw ++;
                }
            }
            if ($game->idTeam1 == $idb && $game->idTeam2 == $ida) {
                if ($game->goals1 > $game->goals2) {
                    $bw ++;
                } elseif ($game->goals1 < $game->goals2) {
                    $aw ++;
                }
            }
        }
        if ($aw > $bw) {
            return -1;
        }
        if ($aw < $bw) {
            return 1;
        }
        return 0;
    }

    function compareMeetGoals ($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        $ag = $bg = 0;
        foreach (self::$games as $game) {
            if ($game->idTeam1 == $ida && $game->idTeam2 == $idb) {
                $ag += $game->goals1;
                $bg += $game->goals2;
                $bg -= $game->goals1;
                $ag -= $game->goals2;
            }
            if ($game->idTeam1 == $idb && $game->idTeam2 == $ida) {
                $bg += $game->goals1;
                $ag += $game->goals2;
                $ag -= $game->goals1;
                $bg -= $game->goals2;
            }
        }
        if ($ag > $bg) {
            return -1;
        }
        if ($ag < $bg) {
            return 1;
        }
        return 0;
    }

    function compareMeetGoalsOnForeigns ($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        $ag = $bg = 0;
        foreach (self::$games as $game) {
            if ($game->idTeam1 == $ida && $game->idTeam2 == $idb) {
                $bg += $game->goals2;
            }
            if ($game->idTeam1 == $idb && $game->idTeam2 == $ida) {
                $ag += $game->goals2;
            }
        }
        if ($ag > $bg) {
            return -1;
        }
        if ($ag < $bg) {
            return 1;
        }
        return 0;
    }

    function compareTotalGoalsDiff ($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        if ($a['goals'] - $a['goals_fail'] > $b['goals'] - $b['goals_fail']) {
            return -1;
        }
        if ($a['goals'] - $a['goals_fail'] < $b['goals'] - $b['goals_fail']) {
            return 1;
        }
        return 0;
    }

    function compareTotalGoals ($ida, $idb) {
        $a = self::$list[$ida];
        $b = self::$list[$idb];
        $ag = $bg = 0;
        if ($a['goals'] > $b['goals']) {
            return -1;
        }
        if ($a['goals'] < $b['goals']) {
            return 1;
        }
        return 0;
    }

    public static function compare($a, $b) {
        $score = self::compareScore($a['id'], $b['id']);
        if (0 != $score) {
            return $score;
        } else {
            $meets = self::compareMeets($a['id'], $b['id']);
            if (0 != $meets) {
                return $meets;
            } else {
                $meetGoals = self::compareMeetGoals($a['id'], $b['id']);
                if (0 != $meetGoals) {
                    return $meetGoals;
                } else {
                    $meetGoalsForeign = self::compareMeetGoalsOnForeigns(
                        $a['id'],
                        $b['id']
                    );
                    if (0 != $meetGoalsForeign) {
                        return $meetGoalsForeign;
                    } else {
                        $totalGoalsDiff = self::compareTotalGoalsDiff(
                            $a['id'],
                            $b['id']
                        );
                        if (0 != $totalGoalsDiff) {
                            return $totalGoalsDiff;
                        } else {
                            $totalGoals = self::compareTotalGoals(
                                $a['id'],
                                $b['id']
                            );
                            return $totalGoals;
                        }
                    }
                }
            }
        }
    }
}
