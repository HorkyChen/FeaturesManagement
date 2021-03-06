<html>
    <head>
        <title>Feature Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body onload="initialize()">

<p>
    Query with Feature ID:
    <input type="number" id="feature_id" onkeydown="if(event.keyCode==13)showFeatureInfo()">
    <button onclick="showFeatureInfo()">Go</button>
    <button onclick="deleteFeature()">Delete</button>
</p>
<p>
    <button onclick="document.location='addFeatureUI.php'">New Feature</button>
</p>
<?php
require('common.php');

$teams = getTableData("select * from TeamList");
$modules = getTableData("select * from ModuleList");

echo 'Tracking Features:<br/>';
$array = array("ID","Feature","Reason","Project");
$query = 'SELECT ID, FeatureName,TrackingReason,Project FROM Features WHERE tracked>0';
showQueryInTable($array, $query);

function showFeaturesByTeamID($team_id) {
    $array = array("ID","Feature","Owner","Project");
    $query = 'SELECT ID, FeatureName,CurrentOwner,Project FROM Features WHERE TeamID='.$team_id;
    showQueryInTable($array, $query);
}
?>
<script type=text/javascript>
    function showFeatureInfo() {
        target_id = document.getElementById('feature_id').value;
        if(target_id>0){
            document.location = 'showDetail.php?id='+target_id;
        }
    }
    function deleteFeature() {
        target_id = document.getElementById('feature_id').value;
        if(target_id>0){
            document.location = 'deleteFeature.php?id='+target_id;
        }
    }
    
    function initialize() {
        var teams = <?php echo $teams; ?>;
        var modules = <?php echo $modules; ?>;
        setSelectionOptions(teams,"team_list");
        setSelectionOptions(modules,"layer_list");
    }
    
    function setSelectionOptions(list, id) {
        objSelect = document.getElementById(id);
        for(var i = 0; i < list.length; i++) {
            objSelect.options[objSelect.length] = new Option(list[i][1], list[i][0]);
        }
    }

    function onItemSelected(selectID, targetFieldID) {
        selectElement = document.getElementById(selectID);
        selectedValue = selectElement.options[selectElement.selectedIndex].value;
        document.getElementById("features_list").src="showFeaturesBy.php?"+targetFieldID+"="+selectedValue;
    }

</script>
<br/>
<p>
    Team List:<select id="team_list" onchange="onItemSelected('team_list','team_id')">
    </select>
    <br/> or Layer List:<select id="layer_list" onchange="onItemSelected('layer_list','layer_id')">
    </select>
</p>
<iframe id="features_list" frameBorder="0" src="showFeaturesBy.php?team_id=1" height="300" width="400"/>
</body>
</html>
    