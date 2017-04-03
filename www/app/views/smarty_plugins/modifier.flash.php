<?php
/**
 * @author Yohann Bianchi<yohann.b@lahautesociete.com>
 * @date   03/04/17 22:01
 * @param SessionHelper $session An instance of the session helper.
 * @param string        $key  The [Message.]key you are rendering in the view.
 * @param bool          $echo `true` to echo the value, `false` to only have it returned.
 * @return string|false       The flash message stored in session, if any, `false` otherwise.
 */
function smarty_modifier_flash(SessionHelper $session, $key = 'flash', $echo = false)
{
    ob_start();
    $session->flash($key);
    $flashMessage = ob_get_clean();

    if (strlen($flashMessage) < 1) {
        $flashMessage = false;
    }

    if ($echo) {
        echo $flashMessage;
    }

    return $flashMessage;
}
