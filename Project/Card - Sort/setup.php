<?php
include "../connect/connect.inc.php";
//////////////////////////////////////////////////////
// Drop Tables
//////////////////////////////////////////////////////
	$dropQuery = "DROP TABLE IF EXISTS experiment";
	$dropResult = mysqli_query($connection, $dropQuery);
	if($dropResult = 1)
	{
		echo("<br> Experiment Dropped Successfully <br>");
	}
	else
	{
		echo("<br> Experiment Failed to Drop");
	}
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
	$dropQuery = "DROP TABLE IF EXISTS card";
	$dropResult = mysqli_query($connection, $dropQuery);
	if($dropResult = 1)
	{
		echo("<br> Card Dropped Successfully <br>");
	}
	else
	{
		echo("<br> Card Failed to Drop");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	$dropQuery = "DROP TABLE IF EXISTS subjectData";
	$dropResult = mysqli_query($connection, $dropQuery);
	if($dropResult = 1)
	{
		echo("<br> Subject Data Dropped Successfully <br>");
	}
	else
	{
		echo("<br> Subject Data Failed to Drop");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	$dropQuery = "DROP TABLE IF EXISTS subjectCard";
	$dropResult = mysqli_query($connection, $dropQuery);
	if($dropResult = 1)
	{
		echo("<br> Subject Card Dropped Successfully <br>");
	}
	else
	{
		echo("<br> Subject Card Failed to Drop");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// Create Tables
///////////////////////////////////////////////////////
	$createQuery = "CREATE TABLE experiment
	(
		experimentID 			INT(6) NOT NULL AUTO_INCREMENT,
		experimentName 			VARCHAR(40) NOT NULL,
		experimentMethod		VARCHAR(20) NOT NULL,

		PRIMARY KEY(experimentID)
	)";
	$createResult = mysqli_query($connection, $createQuery);
	if($createResult = 1)
	{
		echo("<br> Experiment Created Successfully <br>");
		echo("Tables: experimentID INT, experimentName VARCHAR, experimentMethod VARCHAR <br>");
	}
	else
	{
		echo("<br> Experiment Failed to Create");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	$createQuery = "CREATE TABLE card
	(
		cardID 			INT(6) NOT NULL AUTO_INCREMENT,
		cardStatement 	VARCHAR(182) NOT NULL,
		cardQR			INT(2) NOT NULL,
		experimentID	INT(6) NOT NULL,

		PRIMARY KEY(cardID)
	)";
	$createResult = mysqli_query($connection, $createQuery);
	if($createResult = 1)
	{
		echo("<br> Card Created Successfully <br>");
		echo("Tables: cardID INT, cardStatement VARCHAR, cardQR INT, experimentID INT <br>");
	}
	else
	{
		echo("<br> Card Failed to Create");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	$createQuery = "CREATE TABLE subjectData
	(
		subjectID 		INT(6) NOT NULL AUTO_INCREMENT,
		experimentID	INT(6) NOT NULL,
		subjectAge 		INT(3) NOT NULL,
		subjectGender 	VARCHAR(6) NOT NULL,
		subjectImage	VARCHAR(20) NOT NULL,

		PRIMARY KEY(subjectID)
	)";
	$createResult = mysqli_query($connection, $createQuery);
	if($createResult = 1)
	{
		echo("<br> Subject Data Created Successfully <br>");
		echo("Tables: subjectID INT, experimentID INT, subjectAge INT, subjectGender VARCHAR, subjectImage VARCHAR <br>");
	}
	else
	{
		echo("<br> Subject Data Failed to Create");
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	$createQuery = "CREATE TABLE subjectCard
	(
		subjectID 		INT(6) NOT NULL,
		cardID 			INT(6) NOT NULL,
		position 		INT(6) NOT NULL,

		PRIMARY KEY(subjectID, cardID)
	)";
	$createResult = mysqli_query($connection, $createQuery);
	if($createResult = 1)
	{
		echo("<br> Subject Card Created Successfully <br>");
		echo("Tables: subjectCardID INT, subjectID INT, cardID INT, position INT <br>");
	}
	else
	{
		echo("<br> Subject Card to Create");
	}
///////////////////////////////////////////////////////
?>
