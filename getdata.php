<?php

$s = @$_GET['s'];
$e = @$_GET['e'];
$l = @$_GET['l'];
$r = @$_GET['r'];

if ($l<1) {
    $l = 100;
}
if (($s==null)&&($e==null)) {
    $b = time();
    $e = date('Y-m-d H:i:s',$b);
    $s = date('Y-m-d H:i:s',($b-86400)); // 1日前
}
if ($r==null) {
    $o = "";
} else {
    $o = "DESC";
}
$dsn = 'uri:file:///var/www/etc/uecsdbconnect';

try {
    $dbh = new PDO($dsn);
} catch(PDOException $x) {
    echo 'Connection Failed: ',$x->getMessage();
}

//$sql = sprintf("SELECT tod,ccmtype,room,region,ord,priority,value,ip,id FROM data WHERE tod>=:start AND tod<=:end ORDER BY tod %s LIMIT :limit",$o);
$sql = sprintf("SELECT tod,ccmtype,room,region,ord,priority,value,ip,id FROM data WHERE tod>='%s' AND tod<='%s' ORDER BY tod %s LIMIT %d",$s,$e,$o,$l);
$sth = $dbh->query($sql);
$dat = $sth->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($dat);
exit;
?>
