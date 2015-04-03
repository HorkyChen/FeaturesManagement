<html>
    <head>
        <title>Feature List</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body>

<?php
require('common.php');

// Check the query string.
parse_str($_SERVER['QUERY_STRING'], $params);

if(array_key_exists('team_id',$params)) {
    showFeaturesByTeamID($params['team_id']);
}
else if(array_key_exists('layer_id',$params)) {
    showFeaturesByLayerID($params['layer_id']);
}

function showFeaturesByTeamID($team_id) {
    $array = array("ID","Feature","Owner","Project");
    $query = 'SELECT ID, FeatureName,CurrentOwner,Project FROM Features WHERE TeamID='.$team_id;
    showQueryInTable($array, $query);
}

function showFeaturesByLayerID($layer_id) {
    $array = array("ID","Feature","Owner","Project");
    $query = "SELECT ID, FeatureName,CurrentOwner,Project FROM Features WHERE ID in (SELECT FeatureID FROM FeatureLayer where ModulesID=".$layer_id.")";
    showQueryInTable($array, $query);
}
?>

</body>
</html>
    