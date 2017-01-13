<?php

function smarty_modifier_escape_quote($text) {
    return str_replace('\'', '\\\'', $text);
}