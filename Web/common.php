<?php
function showQueryInTable($columns, $query)
{
    echo '<table><tbody><tr>';
    foreach ($columns as $i => $value) {
        echo '<th>'.$columns[$i].'</th>';
    }
    echo '</tr>';
    
    $fieldCount = count($columns);
    
    $db = new PDO('sqlite:FeaturesManagement.db');
    $result = $db->query($query);
    foreach ($result as $row) {
        echo '<tr>';
        $index = 0;
        while ($index < $fieldCount) {
            $stringVal = $row[$index];
            if($columns[$index] == 'ID') {
                $stringVal = '<a href="showDetail.php?id='.$stringVal.'">'.$stringVal.'</a';
            }
            echo '<td>'.$stringVal.'</td>';
            $index++;
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
}

function showRowInTable($columns, $query) {
    $db = new PDO('sqlite:FeaturesManagement.db');
    $result = $db->query($query);
    
    $row = $result->fetch(); //Only show one row.
    
    echo '<table><tbody><tr><th>Property</th><th>Value</th></tr>';

    foreach ($columns as $i => $value) {
        $stringVal = $row[$i];
        if (ereg('^http://', $stringVal)){
            $stringVal = '<a href="'.$stringVal.'">'.$stringVal.'</a>';
        }
        echo '<tr><td>' .$columns[$i].'</td><td>'.$stringVal.'</td></tr>';
    }
    echo '</tr>';

    echo '</tbody></table>';
}

function getTableData($query) {
    $db = new PDO('sqlite:FeaturesManagement.db');
    $result = $db->query($query);
    $rows = $result->fetchAll();
    
    return json_encode($rows);
}

function deleteFeature($featureID) {
    $db = new PDO('sqlite:FeaturesManagement.db');
    $db->beginTransaction();
    $result = $db->exec('delete from Features where ID='.$featureID);
    $result = $db->exec('delete from FeatureLayer where FeatureID='.$featureID);
    $result = $db->exec('delete from Dependencies where FeatureID='.$featureID);
    $db->commit();
}

?>