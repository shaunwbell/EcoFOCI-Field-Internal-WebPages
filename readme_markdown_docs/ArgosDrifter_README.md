Argos Drifter README
====================

Author: Shaun Bell (shaun.bell@noaa.gov)   

Date: June 4, 2015

Purpose: Guide for Processing and Visualization of Daily Drifter Updates.


=== Data Source ===

Data is downloaded from the argos server once a day via a cronjob on pavlof that uses the SOAP protocal for communication and data retrieval.  A copy of the routines used for this automated process are available at 

<pre>pavlof:/home/ecoraid/data/FieldOpsArchive/DrifterOperations/AutomatedRetrievalRoutines</pre>   

Manual retrieval / perusal of the data can be done through an interactive server hosted by argos at https://argos-system.cls.fr/cwi/Logon.do
		
	User - bparker
	password - invest
	
=== Data Archive ===

The data that is retrieved daily is specifically set up to obtain the previous days data stream (from 00:00 to 23:59 UTC) thus each days downloaded data can be considered the initial archive file for the Drifter data archive.  All subsequent processing begins with these files.

=== Data Quality Control ===

Currently Sigrid Salo is responsible for the quality control of the drifter data.

=== Daily Visualizations and monitoring ===

Data which has not been quality controlled is available for visualization on the internal website available at http://pavlof.pmel.noaa.gov/bell/eFOCI_Drifters/  In order to clean the raw archive data up before visualization and to speed up the daily analysis process, a database of deployed drifters exist (see below for more information) and a few simple routines parse the daily archive file into **Daily** files for each **Argos ID**. These tasks are done locally by S. Bell and do not alter the original archive data files.

_Refer to the following when clicking on the tabs at the top of the page:_

==== Drifter Status ====

This is a visual dump of the information contained within the drifter database. It provides general status of when the last time the data for a particular ArgosID was *touched by the daily parse routines (no date update indicates that the specific ID was not found in the daily retrieved files) as well as metainformation provided about the deployment of a specific drifter id (see add/update drifterID)

==== Drifter Quicklooks ====

Organized by year for the last reported date from a drifter - three maps are available: a png which has along track contours for reported temperature, a png which has along track contours for day-of-year as well as periodic labeling of dates (once a week) and a kml file which is viewable in google earth

==== Add/Update Drifter ID ====

This page will let you add a new drifter ID record or update an existing one - **there are no measures to protect the data from user input error - please confirm any changes you make prior to doing so** the only way to recover from a mistake is to reload the database from a prior days backup (backups are created daily but only kept for a few weeks)