<?php
/**
 * Base inclusion file
 *
 */
$rto_dir = dirname(__FILE__);

// Check for a prior definition of HORDE_BASE.
if (!defined('HORDE_BASE')) {
    /* Temporary fix - if horde does not live directly under the imp
     * directory, the HORDE_BASE constant should be defined in
     * imp/lib/base.local.php. */
    if (file_exists($rto_dir . '/base.local.php')) {
        include $rto_dir . '/base.local.php';
    } else {
        define('HORDE_BASE', $rto_dir . '/../..');
    }
}

/* Load the Horde Framework core. */
require_once HORDE_BASE . '/lib/core.php';

/* Registry. */
$session_control = Horde_Util::nonInputVar('session_control');
if ($session_control == 'none') {
    $registry = Horde_Registry::singleton(Horde_Registry::SESSION_NONE);
} elseif ($session_control == 'readonly') {
    $registry = Horde_Registry::singleton(Horde_Registry::SESSION_READONLY);
} else {
    $registry = Horde_Registry::singleton();
}

try {
    $registry->pushApp('timeobjects', array('logintasks' => true));
} catch (Horde_Exception $e) {
    Horde_Auth::authenticateFailure('timeobjects', $e);
}

if (!defined('TIMEOBJECTS_BASE')) {
    define('TIMEOBJECTS_BASE', $rto_dir . '/..');
}
