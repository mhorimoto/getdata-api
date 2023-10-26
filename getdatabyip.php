<?php

$s = @$_GET['s'];
$e = @$_GET['e'];
$l = @$_GET['l'];
$r = @$_GET['r'];
$i = @$_GET['i'];
$v = @$_GET['csv'];

if ($v==null) {
    $v = false;
} else {
    $v = true;
}

if ($i==null) {
    exit;
}

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

$sql = sprintf("SELECT tod,ccmtype,room,region,ord,priority,value,inet_ntoa(ip) as ip,id FROM data WHERE ip=inet_aton('%s') AND tod>='%s' AND tod<='%s' ORDER BY tod %s LIMIT %d",$i,$s,$e,$o,$l);
$sth = $dbh->query($sql);
$dat = $sth->fetchAll(PDO::FETCH_ASSOC);
if ($v) {
    $csvfilename = sprintf("databyip-%s.csv",$b);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$csvfilename);
    printf("tod,ccmtype,room,region,ord,priority,ip,value,id\n");
    foreach($dat as $v) {
        printf("%s,%s,%d,%d,%d,%d,%s,%s,%s\n",$v['tod'],$v['ccmtype'],
        $v['room'],$v['region'],$v['ord'],$v['priority'],$v['ip'],$v['value'],$v['id']);
    }
} else {
    echo json_encode($dat);
}
exit;
?>
