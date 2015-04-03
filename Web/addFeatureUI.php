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
?>
<form action="addNewFeature.php" method="POST">
 <P>
    <table>
        <tbody>
            <tr>
                <th>Property</th> <th>Value</th>
            </tr>
            <tr>
                <td>Feature</td><td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Description</td><td><input type="text" name="description"></td>
            </tr>
            <tr>
                <td>Project</td><td><input type="text" name="project"></td>
            </tr>
            <tr>
                <td>Design Document</td><td><input type="text" name="designdoc"></td>
            </tr>
            <tr>
                <td>Tracked?</td><td><input type="checkbox" name="tracked"></td>
            </tr>
            <tr>
                <td>Why to track</td><td><input type="text" name="tracking_reason"></td>
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
                <td>First Developer</td><td><input type="text" name="first_developer"></td>
            </tr>
            <tr>
                <td>Current Owner</td><td><input type="text" name="current_owner"></td>
            </tr>
            <tr>
                <td>Depend Features</td>
                <td>
                    <input type="text" id="features_id" name="depend_features" hidden="true">
                    <select id="features_list" name="list" multiple  size="15" onchange="onItemSelected('features_list','features_id')" >
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