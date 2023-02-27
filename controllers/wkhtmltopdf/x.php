<?
//$pdf = 'I'.$id.'_S'.$so.'_J'.$jobno.'.pdf';
$url = "http://192.168.1.18/admin/tank_ocean_send_transform_pdf_alt.php?id=11";
exec("wkhtmltopdf $url x.pdf");
?>