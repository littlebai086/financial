<?php
	include 'mio.php';
	if(isset($_GET['id'])){$id = $_GET['id'];}else{$id = '';}

$sql = "select * from tank_ocean_shpt where `id`='".$id."'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
//echo $sql;
$mailto = $row['mailto'];
$cc = $row['cc'];
$subject = $row['subject'];
$so1 = $row['so1'];
$shipper = $row['shipper'];
$booking_remark = $row['booking_remark'];
//$remark_br = str_replace("*","<br>*",$row['remark']);
/***************/
$s = $subject.' SO. '.$so1. '  , SHIPPER. '.$shipper.' BOOKING INFORMATION FROM ' .$booking_remark;
/***************/

$from = $row['smtp'];

$sql2 = "select `signature` from account where username='".$row['attn2']."'";
$result2 = mysqli_query($db,$sql2);
$row2 = mysqli_fetch_row($result2);

$msg_oe = "
<STYLE>
<!--
A.psl {
	TEXT-DECORATION:none; COLOR: #4e81c4
}
A:hover {
	TEXT-DECORATION: underline
}
A.psl:hover {
	COLOR: #999999
}
.noro {
	FONT-SIZE: 8pt; COLOR: #4e81c4; FONT-FAMILY: Verdana,Arial,fixed
}
.tiny {
	FONT-SIZE: 1pt
}
.logotext {
	TEXT-DECORATION: none; FONT-SIZE: 10pt; FONT-FAMILY: Verdana,Arial,fixed
}
A.brand {
	FONT-SIZE: 7pt; COLOR: #ffffff; FONT-FAMILY: Verdana,Arial,fixed; TEXT-DECORATION: underline
}
-->
</STYLE>
<!--<center>-->
<TABLE cellSpacing=0 cellPadding=0 border=0 width=320><TBODY><TR><TD><TABLE cellSpacing=0 cellPadding=0 border=0 align='right' width=320 height=80>
	<TR><TD class=tiny><TABLE width=320 height=100% cellSpacing=0 style='BORDER-RIGHT: #666666 1px solid; BORDER-TOP: #666666 1px solid; BORDER-LEFT: #666666 1px solid; BORDER-BOTTOM: #666666 1px solid'>
	  <TBODY>
	  <TR bgcolor=#ffffff><TD width=100% class=tiny height=1><TABLE border=0 cellspacing=0 cellpadding=1 width=100%>
		<TR><TD class=logotext style='padding-left: 5px'><IMG SRC='http://isotank.qatransport.com/csop/oe.jpg' border=0 ></TD><TD align=right class=noro style='padding-right: 5px; FONT-SIZE: 7pt'>WE DO THE BEST</TD></TR>
	  </TABLE></TD><TD class=tiny></TD></TR>
	  <TR><TD colspan=2><TABLE width=100% height=100% cellSpacing=2 border=0 align='right'>
		<TR height=1 style='padding-bottom: 4px'><TD class=noro valign=top style='padding-left: 4px'>
<B>".$row2[0]."</B><BR>
<I>Ext. ".$row['ext2']."</I>
		</TD><TD class=noro align=right valign=top style='padding-right: 4px'>
<B>&#27915;&#23439;&#32929;&#20221;&#26377;&#38480;&#20844;&#21496; QA TRANSPORT CO</B><BR>
10F, NO. 165, SEC. 4, NANJING EAST ROAD, TAIPEI, TAIWAN 105
		</TD></TR><TR height=1><TD class=noro valign=bottom style='padding-left: 4px; padding-bottom: 4px'>
<A target=_blank class=psl href='mailto:".$row['smtp']."'>".$row['smtp']."</A>
		</TD><TD class=noro align=right valign=bottom style='padding-right: 4px; padding-bottom: 4px'>
<TABLE border=0 cellspacing=0 align=right><TR><TD class=noro align=right nowrap>tel: <BR>
fax: <BR>
Skype ID:</TD><TD class=noro align=right style='padding-left: 4px' nowrap>886 2 6602 8989<BR>
886 2715 0606<BR>
".$row['attn2']."-qat
</TD></TR></TABLE>
		</TD></TR>
	  </TABLE></TD></TR>
	  </TBODY>
	</TABLE></TD>
	<TD></TD></TR>
  </TABLE></TD></TR>
  <TR><TD colspan=2 class=tiny  bgcolor=#4e81c4><TABLE width=100% cellSpacing=0 cellPadding=3><TR><TD align=left><A href='https://www.plaxo.com/add_me?u=60129874190&src=client_sig_212_1_card_join&invite=1&lang=en' target=_blank class=brand><I>Always have my latest info</I></A></TD><TD align=right><A href='http://www.plaxo.com/signature?src=client_sig_212_1_card_sig&lang=en' target=_blank class=brand><I>Want a signature like this?</I></A></TD></TR></TABLE></TD></TR>
</TBODY>
<!--</center>-->
</TABLE>";

/***********************/


/****信件內容****/

$msg = "

<html>
<head>

<title>TANK_OCEAN_SHPT</title>
<style>
	tr{font-weight:bold;}
	.tr_content{height:36px;}
	.content_title{text-align:center;}
	.content_td1{text-align:center;background-color:#99CCFF;color:black;font-weight:bold;font-size:24px;}
	.content_td2{text-align:center;background-color:#99CCFF;color:black;font-weight:bold;font-size:10px;}
	.content_td3{text-align:center;background-color:#99CCFF;color:black;font-weight:bold;font-size:10px;}
	#pre{background-color:#FFF8DC;}
	#td_text{text-align:left;background-color:#FFF8DC;color:black;font-weight:bold;}
	#td_textc{text-align:center;background-color:#FFF8DC;color:black;}
	#td_textr{text-align:right;background-color:#FFF8DC;color:black;}
	.remark{vertical-align:top;}
</style>
</head>

<body>
	<!--<center>-->
	<form>
	<table width='600' border='4'>
		<tr>
			<td class='content_title' colspan='3'><img src='http://192.168.1.18/admin/qa.png'/></td>
		</tr>
		<!--TANK BOOKING INFORMATION-->
		<tr>
			<td class='content_td1' colspan='3'><img src='http://192.168.1.18/admin/booking.jpg'/></td>
		</tr>				
		<tr>
			<td class='content_td2' colspan='3'></td>
		</tr>
		<!-- !!分隔線!! -->
		<tr class='tr_content'>
			<td id='td_text'>TO: ".$row['to']." </td><td id='td_text'>ATTN: ".$row['attn1']." </td><td id='td_text'> FROM: ".$row['from']."</td>		
		</tr>
		<tr class='tr_content'>
			<td id='td_text'>TEL: ".$row['tel']." </td><td id='td_text'> EXT: ".$row['ext1']."</td><td id='td_text' colspan='2'> FAX: ".$row['fax']."</td>
		</tr>
		<tr class='tr_content'>
			<td id='td_text'>E-MAIL:  ".$row['email']."</td><td id='td_text' colspan='2'>DATE: ".$row['date']."，".$row['time']."</td>
		</tr>
		<tr class='tr_content'>
			<td id='td_text'>S/O NO:  ".$row['so1']."</td><td id='td_text' colspan='2'>Job No.: ".$row['jobno1']."</td>
		</tr>
		<tr>
			<td class='content_td2' colspan='3'></td>
		</tr>		
		<tr class='tr_content'>
			<td id='td_text'>結關日: ".$row['cut_off']."</td><td id='td_text'> ETD: ".$row['etd']."</td><td id='td_text'> ETA: ".$row['eta']."</td>
		</tr>		
		<tr class='tr_content'>
			<td id='td_text'>收貨地: ".$row['pol_receipt']."</td><td id='td_text' colspan='2'> 裝船港: ".$row['pol_loading']."</td>			
		</tr>
		<tr class='tr_content'>
			<td id='td_text'>卸貨港: ".$row['pod_discharge']."</td><td id='td_text' colspan='2'> 目的地: ".$row['pod_destination']."</td>			
		</tr>		
		<tr class='tr_content'>
			<td id='td_text'>船名航次: ".$row['vessel_voyage']."</td><td id='td_text' colspan='2'> 船公司: ".$row['carrier']."</td>
		</tr>		
		<tr class='tr_content'>
			<td id='td_text'>產品: ".$row['commodity']."</td><td id='td_text'> 領櫃: ".$row['pick_up1']."</td><td id='td_text'> 交櫃: ".$row['return1']."</td>
		</tr>
		<tr class='tr_content'>
			<td id='td_text'></td><td id='td_text'>".$row['pick_up2']."</td><td id='td_text'>".$row['return2']."</td>
		</tr>
		<tr>
			<td class='content_td1' colspan='3'>REMARK</td>
		</tr>												
		<tr class='tr_content'>			
			<td colspan='3' id='pre'><pre>".$row['remark']."</td></pre>
		</tr>		
		<tr class='tr_content'>			
			<td colspan='3' id='pre'>
				<font size='2'>".$row['pre1'].$row['attn2']."<br/>".$row['pre2'].$row['ext2']."<br/>".$row['pre3']."</font>
			</td>			
		</tr>
		<tr class='tr_content'>
			<td id='td_text'><font size='2'>統一編號: ".$row['sn']." </td><td id='td_text'>專案編號: ".$row['jobno2']." </td><td id='td_text'>國外代理: ".$row['agent']."</font></td>
		</tr>
		<tr>
			<td class='content_td2' colspan='3'></td>
		</tr>			
	</table>
	</form>
	<!--</center>-->
	<p>
<pre><b><font color='#4E81C4'>Best Regards,<br>
".$row['attn2']."</font></b></pre>
	".$msg_oe."<p>
</body>
</html>";

echo $msg;

?>