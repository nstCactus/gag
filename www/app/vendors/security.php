<?php

class Security
{
    public static function hash($content)
    {
        return md5(md5($content) . HASH_SECRET_KEY);
    }
}
