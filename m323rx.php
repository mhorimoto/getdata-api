<?php
$sql       = null;
$res       = null;
$dbh       = null;
$rtod      = "now()";
$devid     = $_GET['D'];
$stod      = $_GET['S'];
$valid     = $_GET['V'];
$latitude  = $_GET['LAT'];
$longitude = $_GET['LON'];
$altitude  = $_GET['ALT'];
$cur_tim   = $_GET['CUR'];
$ac_x      = $_GET['ACX'];
$ac_y      = $_GET['ACY'];
$ac_z      = $_GET['ACZ'];
$sum_E     = $_GET['SUE'];
$a         = $_GET['A'];
$gy_x      = $_GET['GYX'];
$gy_y      = $_GET['GYY'];
$gy_z      = $_GET['GYZ'];
$sum_gyx   = $_GET['SGX'];
$sum_gyy   = $_GET['SGY'];
$sum_gyz   = $_GET['SGZ'];
$x_max     = $_GET['XMA'];
$y_max     = $_GET['YMA'];
$z_max     = $_GET['ZMA'];
$gx_max    = $_GET['GXM'];
$gy_max    = $_GET['GYM'];
$gz_max    = $_GET['GZM'];
$while1sec = $_GET['W1S'];
$t = new DateTime($stod);
$t->setTimeZone(new DateTimeZone('Asia/Tokyo'));
$fp = fopen("/tmp/m323.csv","a");
if ($valid=="A") {
    $sql = sprintf("INSERT INTO data(devid,rtod,stod,valid,latitude,longitude,altitude,cur_tim,ac_x,ac_y,ac_z,sum_E,a,gy_x,gy_y,gy_z,sum_gyx,sum_gyy,sum_gyz,x_max,y_max,z_max,gx_max,gy_max,gz_max,while1sec,msg) VALUES (%s,%s,'%s','%s','%s','%s',%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,null)",
                   $devid,$rtod,$t->format('Y-m-d H:i:s'),$valid,$latitude,$longitude,$altitude,
                   $cur_tim,$ac_x,$ac_y,$ac_z,$sum_E,$a,$gy_x,$gy_y,$gy_z,
                   $sum_gyx,$sum_gyy,$sum_gyz,$x_max,$y_max,$z_max,
                   $gx_max,$gy_max,$gz_max,$while1sec);
} else {
    $sql = sprintf("INSERT INTO data(devid,rtod,stod,valid,cur_tim,ac_x,ac_y,ac_z,sum_E,a,gy_x,gy_y,gy_z,sum_gyx,sum_gyy,sum_gyz,x_max,y_max,z_max,gx_max,gy_max,gz_max,while1sec,msg) VALUES (%s,%s,'%s','%s',%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,null)",
                   $devid,$rtod,$t->format('Y-m-d H:i:s'),$valid,
                   $cur_tim,$ac_x,$ac_y,$ac_z,$sum_E,$a,$gy_x,$gy_y,$gy_z,
                   $sum_gyx,$sum_gyy,$sum_gyz,$x_max,$y_max,$z_max,
                   $gx_max,$gy_max,$gz_max,$while1sec);
}

fprintf($fp,"%s\n",$sql);
fclose($fp);

try {  // Connect DB
    $dbh = new PDO("mysql:host=localhost; dbname=m323db; charset=utf8",'uecs','uecsdbp');
    $res = $dbh->query($sql);
} catch(PDOException $e) {
    echo $e->getMessage();
    die();
}
$sdh = null;
?>
