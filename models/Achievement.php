<?php

interface Achievement {
    public static function hasMetRequirements($user_id);

    public static function getProgress($user_id);
        
    public static function getTitle();

    public static function getDescription();
}
