<?php

function smarty_modifier_ck_delete_p ($html) {

    $withoutP = preg_replace("(<([p]+)>.*?</\\1>)is","",$html);

    return $withoutP;
}