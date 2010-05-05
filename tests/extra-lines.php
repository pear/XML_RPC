<?php

/**
 * Tests how the XML_RPC server handles parameters with empty values.
 *
 * If you are running this test from a SVN checkout, you must rename the working
 * directory from "XML_RPC" to "XML".
 *
 * PHP versions 4 and 5
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  2005-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/XML_RPC
 * @since      File available since Release 1.4.4
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
require_once 'XML/RPC.php';

$input = "First lfs\n\nSecond crlfs\r\n\r\nThird crs\r\rFourth line";

$expect_removed = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<methodCall>
<methodName>nada</methodName>
<params>
<param>
<value><string>First lfs
Second crlfs
Third crs
Fourth line</string></value>
</param>
</params>
</methodCall>
";

$expect_not_removed = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<methodCall>
<methodName>nada</methodName>
<params>
<param>
<value><string>First lfs

Second crlfs

Third crs

Fourth line</string></value>
</param>
</params>
</methodCall>
";


$msg = new XML_RPC_Message('nada', array(XML_RPC_encode($input)));
$msg->createPayload();
if ($msg->payload == $expect_removed) {
    echo "passed\n";
} else {
    echo "PROBLEM\n";
}

$msg = new XML_RPC_Message('nada', array(XML_RPC_encode($input)));
$msg->remove_extra_lines = false;
$msg->createPayload();
if ($msg->payload == $expect_not_removed) {
    echo "passed\n";
} else {
    echo "PROBLEM\n";
}
