Varnish-Dashboard
=================

The Varnish Dashboard is a a way to visulise and manage the a Varnish Cache instance.

<h2>Features</h2>
<ul>
<li>Realtime metrics</li>
<li>VCL Editor</li>
<li>Ban Editor</li>
<li>Alerts</li>
</ul>

<h2>Components used</h2>
The following components are used in the dashboard
<ul>
<li>AdminLTE html admin theme</li>
<li>NodeJS</li>
<li>PHP</li>
</ul>

This is provided as is and is still in development not in full release status.

<h2>Additional NodeJS modules required</h2>
<ul>
	<li>socket.io</li>
	<li>net-snmp</li>
	<li>request</li>
</ul>

<h2>Additional php requirements</h2>
<ul>
	<li>slim</li>
	<li>composer</li>
</ul>

<h2>Install details</h2>
Copy the WebSite directory to your HTTP server directory
Copy the following AdminLTE directories to your HTTP server directory
<ul>
	<li>ajax</li>
	<li>css</li>
	<li>fonts</li>
	<li>img</li>
	<li>js</li>
</ul>
Copy the Ace editor javascript files to your HTTP server js/ace directory

Copy the BackendServer files to the location your going to run the nodejs application from.

Go to your Website directory under data and install the SLIM framework (composer install)

Update your index.php file to point to the nodejs application and update the key used

Go to your Backend Server directory and install the required nodeJS modules:
sudo npm install socket.io
sudo npm install net-snmp
sudo npm install request


Note for the development I'm giving the scripts access to the varnish secret file, you can update the scripts to use: -S copy_of_secret_file -T localhost:6082 to access the varnishadm
