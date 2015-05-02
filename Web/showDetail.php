<html>
    <head>
        <title>Feature Information</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body>
<p>
    <button onclick="history.back()">Back</button>
    <button onclick="doModify();">Edit</button>
</p>
<?php
require('common.php');
parse_str($_SERVER['QUERY_STRING'], $params);
if($params['id']) {
   $feature_ID = $params['id'];
   echo 'Features Information:<br/>';
   $array = array("ID","Feature","Description","Project","Design Document",
                  "Tracked?","Why to track","Team", "First Developer","Current Owner","Status");
   $query = 'SELECT * FROM feature_info WHERE ID=='.$feature_ID;
   showRowInTable($array, $query);
   
   echo '<br/>Implemented in Layers:';
   $array = array("Layer");
   $query = 'SELECT name FROM feature_in_layers WHERE FeatureID=='.$feature_ID;
   showQueryInTable($array, $query);
   
   echo '<br/>Depends on which features:';
   $array = array("ID","Feature");
   $query = 'SELECT b.ID, b.FeatureName from Dependencies as a,Features as b where a.DependedID=b.ID and FeatureID='.$feature_ID;
   showQueryInTable($array, $query);
   
   echo '<br/>Which features depend on it:';
   $array = array("ID","Feature");
   $query = 'SELECT b.ID, b.FeatureName from Dependencies as a,Features as b where a.FeatureID=b.ID and DependedID='.$feature_ID;
   showQueryInTable($array, $query);
} else {
   echo 'Not specified any feature.';    
}

?>

<script type="text/javascript">
 function doModify() {
    document.location = 'addFeatureUI.php?id='+getParameterByName('id');
 }
 
 function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
</script>
</body>
</html>
    