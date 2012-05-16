<?php
$this->load->helper('url');
$base_url = base_url();
$this->lang->load('idslot');
?>
<html>
<head>
<script type="text/javascript">
<!--
function redirect(){
    alert(<?php echo $msg; ?>);
    window.location = "<?php echo $base_url; ?>#contact";
}
//-->
</script>
</head>
<body onload='redirect()'>
</body>
</html>