<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Add New Records</title>
</head>
<body>

<!-- php includes -->
<?php
include('php_routines/iceprofiler_php_routines.php');


?>

<?php
//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
//operations_prof DB add
/*

  `Project` varchar(15) NOT NULL DEFAULT 'EcoFOCI' COMMENT 'EcoFOCI',
  `Agency` varchar(15) NOT NULL DEFAULT 'PMEL' COMMENT 'PMEL',
  `ProjectURL` varchar(40) NOT NULL DEFAULT 'http://www.ecofoci.noaa.gov' COMMENT 'http://www.ecofoci.noaa.gov',
  `DataURL` varchar(40) NOT NULL DEFAULT 'http://www.ecofoci.noaa.gov' COMMENT 'http://www.ecofoci.noaa.gov',
  `Collaborators` text,
  `ScientificDisciplines` varchar(40) NOT NULL DEFAULT 'Oceanography, Atmospheric Science' COMMENT 'Oceanography, Atmospheric Science',
  `SurveyType` varchar(15) NOT NULL DEFAULT 'timeseries' COMMENT 'timeseries',
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$Project = htmlspecialchars($_POST['Project']); 
$Agency = htmlspecialchars($_POST['Agency']);
$ProjectURL = htmlspecialchars($_POST['ProjectURL']);
$DataURL = htmlspecialchars($_POST['DataURL']);
$Collaborators = htmlspecialchars($_POST['Collaborators']);
$ScientificDisciplines = htmlspecialchars($_POST['ScientificDisciplines']);
$SurveyType = htmlspecialchars($_POST['SurveyType']);


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `operations_iceprof` ( MooringID, Project, Agency, ProjectURL,
    DataURL, Collaborators, ScientificDisciplines, SurveyType) VALUES ('".$MooringID."','".$Project."','".$Agency."','".$ProjectURL."','".$DataURL."','".$Collaborators."',
    '".$ScientificDisciplines."','".$SurveyType."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Meta Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>