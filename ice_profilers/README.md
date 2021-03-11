# README

[Ice Profiler Database][IPDB]
================

[pavlof.pmel.noaa.gov/bell/ice_profilers/][IPDB]

Purpose:
--------

A database and webportal exists for archiving and concatenating all relevant information regarding _cruises_, _moorings_, _instrument calibrations_, and _instrument history_.  This database also maintains general metadata information about *moorings and their locations*, *existing data sets*, and other pertinant information regarding the Ice Profilers affiliated with EcoFOCI.  

General Use:
------------

There are multiple ways to access the content of the EcoFOCI database currently housed on Pavlof:

* Via mysql commandline (user=viewer password='none' for readonly access)
* Via the currently developed webportal (running on pavlof) which limits user access to predefined actions such as viewing, modifying or adding entries
* Via managament programs such as SequelPro
* Via prepackaged utilities such as phpmyadmin (part of the LAMP/MAMP installation package)
  
		The later two options require admin rights for full functionality.  
		
## Basic Web Functionality:

Most users will perform one of the following three functions:  

* Add Ice Profiler Related Records  
* View existing Ice Profiler Records
* View Ice Profiler Status

## Extended Web Functionality:

***Future:***  

+ Sort Records  
+ Update Existing Records (with authorization)  
+ Delete Records (with authorization)

-------------------------------------------------------------

Database Structure:
-------------------
**Parent Database --> IceProfilers**  

**Child Tables --> Instruments (inst_iceprof)**  

	Basic Instrument characteristics.
		A Unique ID (Serial Number and Model)
		Factory Firmware Version
		Purchase Date
		Is an active instrument
		General Notes

### Records should be updated as instruments are acquired, retired, or loaned

####Note: As this is a relational database, instruments must be in the Instrument table before additional histories can be created.


**Child Tables --> Instrument Calibrations (cal_iceprof)**  

	Calibration characteristics.
		A Unique ID (Serial Number and Model)
		Calibration type (inhouse/vendor)
		Date of Calibration
		Calibration Factors
		
### Records should be updated as instruments are calibrated (especially if new calibration factors are determined)


**Child Tables --> Mooring Deployment Records (operations_iceprof, meta_iceprof)**  
  
	Mooring Deployment characteristics.
		A unique Mooring ID is required for these tables.

### Records should be updated as during active deployments (preparations, in-field, post analysis)


**Child Tables --> Time Comparisons (timecheck_iceprof)**  

	Used to log GPS->Instrument time differences

**Child Tables --> Instrument Upgrades (upgrade_iceprof)**  

	Used to log modifications to instruments (e.g. swapping of pressure sensors, changing of firmware version, etc.)

**Child Tables --> Vendor Software (software_iceprof)**  

	Used to log versions of vendor software and firmware so that instruments are up-to-date when deployed


-------------------------------------------------------------


### Data Entry Tools:

All Records can be added through the `Add New Records` tab on the database homepage.

-------------------------------------------------------------



Cleanup Tasks:
--------------

* Look for empty records
* Maintain consistency with lat/lon format and time format  

Future Plans:
-------------

* Link deployment information (cruises and moorings) to data sets.  
* Provide additional instrument characteristics on status page.  
* Provide instrument record analysis as a function over time.  
* Provide Error Support Explicitly
* Provide Updating ability

Notes:
------

ERRORS:
-------------

*Clues if you see the following errors:*  

`Cannot add or update a child row` - any entry that requires a serial number and an instr_id will fail if these are not already in the Instrument database, eg. instruments must exist in the database to have events associated with them.  


[IPDB]: pavlof.pmel.noaa.gov/bell/ice_profilers/
