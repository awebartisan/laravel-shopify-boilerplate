<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div style="display:none" id="url" data-url="<?php echo $url; ?>"></div>
<script type="text/javascript">
    var url = document.getElementById("url").getAttribute("data-url");
    window.top.location.href = url;
</script>
</body>
</html>