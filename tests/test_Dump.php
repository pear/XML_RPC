<?php
require_once('../Dump.php');

$val = new XML_RPC_Value(array(
    'title'    =>new XML_RPC_Value('das ist der Titel', 'string'),
    'startDate'=>new XML_RPC_Value(mktime(0,0,0,13,11,2004), 'dateTime.iso8601'),
    'endDate'  =>new XML_RPC_Value(mktime(0,0,0,15,11,2004), 'dateTime.iso8601'),
    'error'    =>'string',
    'arkey'    => new XML_RPC_Value( array(
        new XML_RPC_Value('simple string'),
        new XML_RPC_Value(12345, 'int')
        ), 'array')
    )
    ,'struct');

XML_RPC_Dump($val);

echo '==============' . "\r\n";
$val2 = new XML_RPC_Value(44353, 'int');
XML_RPC_Dump($val2);

echo '==============' . "\r\n";
$val3 = new XML_RPC_Value('this should be a string', 'string');
XML_RPC_Dump($val3);

echo '==============' . "\r\n";
$val4 = new XML_RPC_Value(true, 'boolean');
XML_RPC_Dump($val4);
?>
