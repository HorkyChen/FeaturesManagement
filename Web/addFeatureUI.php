<html>
    <head>
        <title>Feature Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body onload="initialize()">
<?php
    require('common.php');
    $teams = getTableData("select * from TeamList");
    $modules = getTableData("select * from ModuleList");
    $features = getTableData("select ID,FeatureName from Features");
    
    parse_str($_SERVER['QUERY_STRING'], $params);
    if(array_key_exists('id',$params) && $params['id']) {
      $target_featureID = $params['id'];
      $feature_data = getTableData("SELECT * FROM features WHERE ID==".$target_featureID);
      $feature_modules = getTableData("SELECT ModulesID FROM featurelayer WHERE FeatureID==".$target_featureID);
      $feature_depend = getTableData("SELECT DependedID FROM dependencies WHERE FeatureID==".$target_featureID);
    }
    else{
        $target_featureID = -1;
        $feature_data = 0;
        $feature_modules = 0;
        $feature_depend = 0;
    }
?>
<form action="addNewFeature.php" method="POST">
 <P>
    <table>
        <tbody>
            <tr>
                <th>Property</th> <th>Value</th>
            </tr>
            <tr>
                <input type="text" id="feature_id" name="feature_id" hidden="true">
                <td>Feature</td><td><input id="feature_name" type="text" name="name"></td>
            </tr>
            <tr>
                <td>Description</td><td><input id="description" type="text" name="description"></td>
            </tr>
            <tr>
                <td>Project</td><td><input id="project" type="text" name="project"></td>
            </tr>
            <tr>
                <td>Design Document</td><td><input id="designdoc" type="text" name="designdoc"></td>
            </tr>
            <tr>
                <td>Tracked?</td><td><input id="tracked" type="checkbox" name="tracked"></td>
            </tr>
            <tr>
                <td>Why to track</td><td><input id="tracking_reason" type="text" name="tracking_reason"></td>
            </tr>
            <tr>
                <td>Team</td>
                <td>
                    <input type="text" id="team_id" name="team" hidden="true">
                    <select id="team_list" onchange="onItemSelected('team_list','team_id')">
                        <option value="-1">Unspecified</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Implemented in Layers</td>
                <td>
                    <input type="text" id="layers_id" name="layers" value="-1" hidden="true">
                    <select id="implementation_layers" multiple  size="7" onchange="onItemSelected('implementation_layers','layers_id')">
                        <option value="-1">Unspecified</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>First Developer</td><td><input id="first_developer" type="text" name="first_developer"></td>
            </tr>
            <tr>
                <td>Current Owner</td><td><input id="current_owner" type="text" name="current_owner"></td>
            </tr>
            <tr>
                <td>Depend Features</td>
                <td>
                    <input type="text" id="features_id" name="depend_features" hidden="true">
                    <select id="features_list" name="list" multiple  size="15" onchange="onItemSelected('features_list','features_id')" >
                    </select>
                </td>
            </tr>
            <tr>
                <td>Development Status</td><td><input id="status" type="text" name="status" hidden="true">
                <select id="develop_state" onchange="onItemSelected('develop_state','status')">
                        <option value="0">Not Developed</option>
                        <option value="1">Developed</option>
                </select>
                </td>
            </tr>      
        </tbody>
    </table>
    <INPUT type="submit" value="Submit"> <INPUT type="reset">
 </P>
</form>

<script type="text/javascript">
function initialize() {
    var teams = <?php echo $teams; ?>;
    var modules = <?php echo $modules; ?>;
    var features = <?php echo $features; ?>;
    setSelectionOptions(teams,"team_list");
    setSelectionOptions(features, "features_list");
    setSelectionOptions(modules, "implementation_layers")
    
    var target_featureID = <?php echo $target_featureID; ?>;
    if (target_featureID != -1) {
        // Show detail data.
        var feature_data = <?php echo $feature_data; ?>;
        var feature_modules = <?php echo $feature_modules; ?>;
        var feature_depend = <?php echo $feature_depend; ?>;
        document.getElementById("feature_id").value = target_featureID;
        document.getElementById("feature_name").value = feature_data[0]["FeatureName"];
        document.getElementById("description").value = feature_data[0]["Description"];
        document.getElementById("project").value = feature_data[0]["Project"];
        document.getElementById("designdoc").value = feature_data[0]["DesignDoc"];
        document.getElementById("tracked").value = feature_data[0]["tracked"];
        document.getElementById("tracking_reason").value = feature_data[0]["TrackingReason"];
        document.getElementById("first_developer").value = feature_data[0]["FirstOwner"];
        document.getElementById("current_owner").value = feature_data[0]["CurrentOwner"];
        
        teamElement = document.getElementById("team_list");
        teamElement.options[feature_data[0]["TeamID"]].selected = true;
        teamElement = document.getElementById("develop_state");
        teamElement.options[feature_data[0]["Status"]].selected = true;
        
        setSelectedOptions(feature_modules,"implementation_layers");
        setSelectedOptions(feature_depend,"features_list");
        
        onItemSelected('team_list','team_id');
        onItemSelected('implementation_layers','layers_id');
        onItemSelected('features_list','features_id');
    }

    onItemSelected('develop_state','status');
}

function setSelectedOptions(list,select_id) {
    selectElement = document.getElementById(select_id);
    for(var i = 0; i < list.length; i++) {
        for(var j=0;j<selectElement.options.length;j++) {
            if(selectElement.options[j].value == list[i][0]) {
                selectElement.options[j].selected = true;
            }
        }
    }
}

function setSelectionOptions(list, id) {
    objSelect = document.getElementById(id);
    for(var i = 0; i < list.length; i++) {
        objSelect.options[objSelect.length] = new Option(list[i][1], list[i][0]);
    }
}

function onItemSelected(selectID,inputID) {
    selectElement = document.getElementById(selectID);
    inputElement = document.getElementById(inputID);
    
    updateSelectedValueToInput(selectElement, inputElement);
}

function updateSelectedValueToInput(selectElement,inputElement) {
    var value = "";
    for(var i=0;i<selectElement.options.length;i++) {
       if(selectElement.options[i].selected) {
        value = value + selectElement.options[i].value + ",";
       }
    }
    inputElement.value = value.substring(0,value.length-1);
}

</script>
</body>
</html>