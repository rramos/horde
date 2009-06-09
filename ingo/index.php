<?php
/**
 * Index script.
 *
 * Copyright 2002-2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (ASL).  If you
 * did not receive this file, see http://www.horde.org/licenses/asl.php.
 *
 * @author Mike Cochrane <mike@graftonhall.co.nz>
 */

require_once dirname(__FILE__) . '/base.load.php';
$ingo_configured = (is_readable(INGO_BASE . '/config/conf.php') &&
                    is_readable(INGO_BASE . '/config/prefs.php') &&
                    is_readable(INGO_BASE . '/config/backends.php') &&
                    is_readable(INGO_BASE . '/config/fields.php'));

if (!$ingo_configured) {
    require HORDE_BASE . '/lib/Test.php';
    Horde_Test::configFilesMissing('Ingo', INGO_BASE,
        array('conf.php', 'prefs.php', 'backends.php'),
        array('fields.php' => 'This file defines types of credentials that a backend might request.'));
}

require INGO_BASE . '/filters.php';
