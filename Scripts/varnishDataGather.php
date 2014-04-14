<?php
	$con=mysqli_connect("localhost", "user","password","dbname");
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

    $varnishstatoutput = shell_exec('/usr/bin/varnishstat -1');
	preg_match('/client_conn.+?(\d+)/', $varnishstatoutput, $clientConnArray);
	preg_match('/client_req.+?(\d+)/', $varnishstatoutput, $clientReqArray);
    preg_match('/cache_hit.+?(\d+)/', $varnishstatoutput, $hitCountArray);
    preg_match('/cache_miss.+?(\d+)/', $varnishstatoutput, $missCountArray);
    preg_match('/backend_conn.+?(\d+)/', $varnishstatoutput, $backend_conn_Array);
    preg_match('/backend_unhealthy.+?(\d+)/', $varnishstatoutput, $backend_unhealthy_Array);
    preg_match('/backend_busy.+?(\d+)/', $varnishstatoutput, $backend_busy_Array);
    preg_match('/backend_fail.+?(\d+)/', $varnishstatoutput, $backend_fail_Array);
    preg_match('/backend_reuse.+?(\d+)/', $varnishstatoutput, $backend_reuse_Array);
    preg_match('/backend_toolate.+?(\d+)/', $varnishstatoutput, $backend_toolate_Array);
    preg_match('/backend_recycle.+?(\d+)/', $varnishstatoutput, $backend_recycle_Array);
    preg_match('/backend_retry.+?(\d+)/', $varnishstatoutput, $backend_retry_Array);


	$sql = "INSERT INTO varnishstat (server,cache_hit,cache_miss,client_conn,client_req,backend_conn,backend_unhealthy,backend_busy,backend_fail,backend_reuse,backend_toolate,backend_recycle,backend_retry) VALUES ('DEFAULT', '$hitCountArray[1]', '$missCountArray[1]', '$clientConnArray[1]', '$clientReqArray[1]', '$backend_conn_Array[1]', '$backend_unhealthy_Array[1]', '$backend_busy_Array[1]', '$backend_fail_Array[1]', '$backend_reuse_Array[1]', '$backend_toolate_Array[1]', '$backend_recycle_Array[1]', '$backend_retry_Array[1]')";
	if (!mysqli_query($con,$sql)) {
		echo 'error inserting into db';
	}

	mysqli_close($con);
?>

