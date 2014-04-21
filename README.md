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
</ul>

For AdminLTE see https://github.com/almasaeed2010/AdminLTE - you will need to copy the following folders into public/
<ul>
	<li>ajax</li>
	<li>css</li>
	<li>fonts</li>
	<li>img</li>
	<li>js</li>
</ul>

This is provided as is and is still in development not in full release status.

Update the config.js to hold the details of the connections and the update interval and update the secret file for your varnish secret info.

<h2>REST Interface</h2>
/vcl - get the list of vcls loaded into Varnish
/vcl/static - get the list of static vcls that have been saved to file
/vcl/static/:vclName -
get - the contents of the vcl from file
put - update the vcl to file
delete - delete the vcl file

/vcl/snippet - get the available snippets

/vcl/:vclName
post - save the vcl
get - get the contents of the vcl
put - update the vcl
delete - delete the vcl

/vcl/:vclName/activate
put - activate the vcl

/vcl/snippet/:snippetname - get the content of the snippet

/ban
get - get the ban list
post - add a ban

/status - gets the status of varnish

/stop - post to stop varnish

/start - post to start varnish

/stats - get the varnish stats

/stat/:stat - get a particular stat

/backends - get the list and status of the backends

/event - post in an event