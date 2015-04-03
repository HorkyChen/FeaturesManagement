<html>
    <head>
        <title>Add Feature</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body>
<p>
    <button onclick="history.back()">返回</button>
</p>
<?php
  $db = new PDO('sqlite:FeaturesManagement.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->beginTransaction();
  // Prepare the statement.
  $statement = "Insert into Features(FeatureName,Description,Project,DesignDoc,tracked,TrackingReason,TeamID,FirstOwner,CurrentOwner) Values('".$_POST['name']."','".$_POST['description']."','".$_POST['project']."',";
  if(array_key_exists('designdoc',$_POST)) {
      $statement .= "'".$_POST['designdoc']."',";
  }
  else {
      $statement .= "'',";
  }
  
  if(array_key_exists('tracked',$_POST) && $_POST['tracked'] == "on") {
      $statement .= "1,";
  }
  else {
      $statement .= "0,";
  }
  
  if(array_key_exists('tracking_reason',$_POST)) {
      $statement .= "'".$_POST['tracking_reason']."',";
  }
  else {
      $statement .= "'',";
  }
  
  $statement .= $_POST['team'].",";
  
  if(array_key_exists('first_developer',$_POST)) {
      $statement .= "'".$_POST['first_developer']."',";
  }
  else {
      $statement .= "'',";
  }
  if(array_key_exists('current_owner',$_POST)) {
      $statement .= "'".$_POST['current_owner']."'";
  }
  else {
      $statement .= "''";
  }
  
  $statement .= ")";

  if($db->exec($statement) == 0){
      echo "Failed to insert new features.";
  }
  else {
      // Update module list
      if (array_key_exists('layers', $_POST)) {
          $layerList = split(',', $_POST['layers']);
          foreach($layerList as $layer) {
              if($layer!='-1') {
                $db->exec("Insert into FeatureLayer Values((select max(ID) from Features),".$layer.")");
              }
              
          }
      }
      
      // Update the dependencies.
      if (array_key_exists('depend_features', $_POST) && $_POST['depend_features']!='') {
          $featureList = split(',', $_POST['depend_features']);
          foreach($featureList as $feature) {
            $db->exec("Insert into Dependencies Values((select max(ID) from Features),".$feature.")");
          }
      }
    }
  $db->commit();
  echo "New feature has been inserted!"
?>

</body>
</html>
    