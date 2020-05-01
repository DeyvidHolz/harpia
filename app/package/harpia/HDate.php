<?php

class HDate {

    public static function add($str, $interval) {
        try {
            $date = new DateTime($str);
            $date->modify('+'.$interval);
            return $date->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function subtract($str, $interval) {
        try {
            $date = new DateTime($str);
            $date->modify('-'.$interval);
            return $date->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function calc($str, $interval) {
        try {
            $date = new DateTime($str);
            $date->modify($interval);
            return $date->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function diff($str1, $str2, $in = 'd') {
        try {
            switch ($in) {
                case 'd':
                    return (strtotime($str1) - strtotime($str2))/60/60/24;
                case 'h':
                    return ((strtotime($str1) - strtotime($str2))/60/60/24) * 60;
                case 'm':
                    return ((strtotime($str1) - strtotime($str2))/60/60/24) * 60 * 60;
                case 's':
                    return ((strtotime($str1) - strtotime($str2))/60/60/24) * 60 * 60 * 60;
                default:
                    return ((strtotime($str1) - strtotime($str2))/60/60/24) * 60 * 60 * 60 * 1000;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

}