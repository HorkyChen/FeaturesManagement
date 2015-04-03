<html>
    <head>
        <title>Feature Information</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body>
<p>
    <button onclick="history.back()">返回</button>
</p>
<?php
require('common.php');
parse_str($_SERVER['QUERY_STRING'], $params);
if($params['id']) {
   $feature_ID = $params['id'];
   deleteFeature($feature_ID);
   echo "Specified feature has been removed!";
} else {
   echo '未指定任何Feature.';    
}

?>

</body>
</html>
    