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

if($params['team_id']) {
    showFeaturesByTeamID($params['team_id']);
}
else if($params['layer_id']) {
    showFeaturesByLayerID($params['layer_id']);
}

function showFeaturesByTeamID($team_id) {
    $array = array("ID","Feature","Owner","Project");
    $query = 'SELECT ID, FeatureName,CurrentOwner,Project FROM Features WHERE TeamID='.$team_id;
    showQueryInTable($array, $query);
}

function showFeaturesByLayerID($layer_id) {
    $array = array("ID","Feature","Owner","Project");
    // To be implemented.
}
?>

</body>
</html>
    