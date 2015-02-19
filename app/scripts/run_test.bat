@ECHO OFF
Schtasks /Create /TN "tsktdsk" /XML "C:\wamp\www\SmSiteNew\app\scripts\runtest.xml"
PAUSE