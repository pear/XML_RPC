<?php

/**
 * Actually performs an XML_RPC request.
 *
 * If you are running this test from a SVN checkout, you must rename the working
 * directory from "XML_RPC" to "XML".
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  2005-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/XML_RPC
 * @since      File available since Release 1.5.3
 */

/*
 * If the package version number is found in the left hand
 * portion of the if() expression below, that means this file has
 * come from the PEAR installer.  Therefore, let's test the
 * installed version of XML_RPC which should be in the include path.
 * 
 * If the version has not been substituted in the if() expression,
 * this file has likely come from a SVN checkout or a .tar file.
 * Therefore, we'll assume the tests should use the version of
 * XML_RPC that has come from there as well.
 */
if ('@package_version@' != '@'.'package_version'.'@') {
    /**
     * Get the needed class from the PEAR installation
     */
    require_once 'XML/RPC/Server.php';
} else {
    if (substr(dirname(__FILE__), -9, -6) != 'XML') {
        echo "The parent directory must be named 'XML'.\n";
        exit(1);
    }

    ini_set('include_path', '../../'
            . PATH_SEPARATOR . '.' . PATH_SEPARATOR
            . ini_get('include_path')
    );

    /**
     * Get the needed class from the parent directory
     */
    require_once '../RPC.php';
    require_once '../Dump.php';
}

$debug = 0;

$params = array(
    new XML_RPC_Value('php.net', 'string'),
);
$msg =& new XML_RPC_Message('domquery', $params);
$client =& new XML_RPC_Client('/api/xmlrpc', 'www.adamsnames.com');
$client->setDebug($debug);

$resp =& $client->send($msg);
if (!$resp) {
    echo 'Communication error: ' . $client->errstr;
    exit(1);
}
if ($resp->faultCode()) {
    /*
     * Display problems that have been gracefully cought and
     * reported by the xmlrpc.php script
     */
    echo 'Fault Code: ' . $resp->faultCode() . "\n";
    echo 'Fault Reason: ' . $resp->faultString() . "\n";
    exit(1);
}

$val = $resp->value();
XML_RPC_Dump($val);
