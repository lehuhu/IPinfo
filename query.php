<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	/*
		查询所有IP数据
	*/
	include_once("config.php");
	include_once("class/qqwry.php");
	include_once("class/Query.Class.php");
	//获取IP
	@$ip = $_GET['ip'];

	//如果不是一个IP
	if(!filter_var($ip, FILTER_VALIDATE_IP)){
		//如果是正常的URL
		if(filter_var($ip, FILTER_VALIDATE_URL)){
			$domain = parse_url($ip);
			$host = $domain['host'];
			@$ip = gethostbyname($host);
		}
		else{
			echo "<h1>不是有效的IP或URL！</h1>";
			exit;
		}
		
	}

	//查询接口数据
	$ipip = $query->caches($ip,'ipip');
	if ( $ipip == null )
	{
		$ipip = $query->caches($ip,'ipip');
	}
	$ipip = json_decode($ipip);
	

	$taobao = $query->caches($ip,'taobao');
	if ( $taobao == null )
	{
		$taobao = $query->caches($ip,'taobao');
	}
	$taobao = json_decode($taobao);

	$geoip = $query->caches($ip,'geoip');
	if($geoip == null){
		$geoip = $query->caches($ip,'geoip');
	}
	$geoip = json_decode($geoip);

	$pure = $query->caches($ip,'qqwry');
	if($pure == null){
		$pure = $query->caches($ip,'qqwry');
	}
	$pure = json_decode($pure);

	//返回所有接口数据
?>

<!--返回全部查询结果-->
<div id = "allinfo">
	<h1 style = "text-align:center;margin-bottom:40px;"> <code id = "allip"><?php echo $ipip->ip; ?></code> 查询结果</h1>
	<table class="layui-table">
	  <colgroup>
	    <col width="150">
	    <col width="620">
		<col>
	  </colgroup>
	  <thead>
	    <tr>
	      <th>数据来源</th>
	      <th>地区/运营商</th>
	      <td>缓存时间</td>
	    </tr> 
	  </thead>
	  <tbody id = "ipinfo">
	    <tr>
		  	<td>IPIP.NET</td>
		  	<td id = "ipip"><?php echo $ipip->address; ?></td>
		  	<td id = "ipip">
			  	<?php echo $ipip->date; ?>
			  	&nbsp;&nbsp; <a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-danger" onclick = "dcache('<?php echo $ipip->ip; ?>','<?php echo $ipip->source ?>')">清除缓存</a>
		  	</td>
		</tr>
		<tr>
		  	<td>淘宝</td>
		  	<td id = "taobao"><?php echo $taobao->address; ?></td>
		  	<td id = "ipip">
			  	<?php echo $taobao->date; ?>
			  	&nbsp;&nbsp; <a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-danger" onclick = "dcache('<?php echo $taobao->ip; ?>','<?php echo $taobao->source ?>')">清除缓存</a>
		  	</td>
		</tr>
		<tr>
		  	<td>GeoIP</td>
		  	<td id = "taobao"><?php echo $geoip->address; ?></td>
		  	<td id = "ipip">
			  	<?php echo $geoip->date; ?>
			  	&nbsp;&nbsp; <a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-danger" onclick = "dcache('<?php echo $geoip->ip; ?>','<?php echo $geoip->source ?>')">清除缓存</a>
		  	</td>
		</tr>
		 <tr>
		  	<td>纯真IP</td>
		  	<td id = "qqwry"><?php echo $pure->address; ?></td>
		  	<td id = "ipip">
			  	<?php echo $pure->date; ?>
			  	&nbsp;&nbsp; <a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-danger" onclick = "dcache('<?php echo $pure->ip; ?>','<?php echo $pure->source ?>')">清除缓存</a>
		  	</td>
		</tr>
	  </tbody>
	</table>
</div>
<!--返回全部查询结果END-->
