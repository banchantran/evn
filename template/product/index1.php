<div class="main-content">
<?php
	global $database;
	global $current_lang;
	$url1 = getParam(1, 'str');
	$url2 = getParam(2, 'str');
	$url4 = getParam(4, 'str');
	$query = 'SELECT * FROM `product` WHERE lang="'.$current_lang.'" AND url = "'.$url1.'"  AND sub_url = "'.$url2.'" AND product_url = "'.$url4.'" AND publish =2 ORDER BY region, id DESC';
			$database->setQuery($query);
			$one = $database->loadRow();
			if($one){
?>

						<h1><?php echo $one['title']; ?></h1>
                        <br />
                        <div class="product-box">
                        <div class="box main-box">
                        <div class="box-left">
                        <div class="box-right">
                        <div class="box-top">
                        <div class="box-bot">
                        <div class="box-tl">
                        <div class="box-br">
                        <div class="title">
                        <h2 class="product-logo"><?php echo $one['model']; ?></h2>                        
                        <?php
                        $image_file = get_image($one, 'large', 'product');
					if($image_file)
						echo '<img style="margin:20px;" height="150px" src="'.$image_file.'" alt="'.$one['title'].'">';
						?>
                        </div>
                        <br>
                        <p><?php echo $one['brief']; ?></p>
<div class="more-text">
<br>
<br>
<div class="des" style="display: none;">
<p>The traditional solution to providing an accurate reference time
has been to use an atomic clock radio receiver or GPS sensor linked
to an expensive rack-mounted master clock server, typically with
serial-only output. Network output versions tend to be even more
expensive. For this reason, master reference clocks are normally
only used in very high-end installations such as city centres,
airports and prisons. TIMENET integrates the GPS receiver and
master NTP clock server into a single device which can be directly
connected to the network. TIMENET is extremely compact, can be
wall-mounted, uses very little power and is less than half the cost
of competing solutions.</p>

<ul>
<li>Accurate universal atomic clock reference</li>

<li>Supports all NTP compatible devices</li>

<li>Ideal for CCTV and DVR applications</li>

<li>Far lower cost than competing products</li>

<li>Ideal for closed or secure networks</li>

<li>Direct network interface for remote siting</li>

<li>Simple setup - One IP address</li>

<li>Automatic GPS lock and time sync</li>
</ul>

<p>&nbsp;</p>

<ul>
<li>Extremely compact design</li>

<li>Indoor location (antenna on a window)</li>

<li>Wall mounting</li>

<li>Integral watchdog for long-term reliable operation</li>

<li>Robust, self contained unit</li>

<li>Wide operating temperature range</li>

<li>Very low power use</li>
</ul>

<p><br>
<br>
</p>

<p><br>
<span class="threeH">TIMENET installation and setup</span><br>
TIMENET is then connected to the network through its RJ45 connector
directly to the CCTV/DVR network using a standard CAT5 cable (up to
100m long). The TIMENET setup program is run on any Windows PC, and
the only parameter to set is the desired IP address of the TIMENET
device. This completes the time server installation.<br>
<br>
Any DVR or other NTP-compatible network devices can now be
programmed to get their NTP time signals from the IP address of the
TIMENET server.<br>
<br>
The time server unit is very simple to install and set up. The GPS
antenna is included with the TIMENET product. The antenna itself is
provided with a self-adhesive surface which can be affixed to any
window which has a view of some sky (to pick up the GPS satellite
transmissions). The TIMENET unit can be positioned anywhere within
the 3m reach of the antenna lead, and may be conveniently
wall-mounted with the integral brackets supplied.</p>

<p><br>
<span class="threeH">About UTC Time</span></p>

<p>Universal co-ordinated time is an official world-wide atomic
clock standard for time, agreed by national standards around the
world. UTC time copes with variations in the earth's rotation by
the introduction of leap-seconds at pre-defined intervals. GPS time
references incorporate this automatically. Therefore TIMENET will
continuously provide an accurate UTC clock reference
automatically.</p>

<p><br>
<span class="threeH">About NTP</span><br>
NTP stands for Network Time Protocol and is a universal standard
for time synchronisation of computers or other devices on a
network. TIMENET is NTP-compatible and acts as a time server for
any NTP-enabled client.</p>

<p><br>
<span class="threeH">About GPS</span><br>
GPS is a global satellite system used primarily for position
location, using very accurate atomic clock references. GPS signals
are far less prone to interference than traditional national radio
clock signals. Thus TIMENET is a universal solution which can be
used anywhere in the world.<br>
About Time Zone.</p>

<p><br>
UTC is effectively a GMT reference time and TIMENET provides this
via NTP as a universal reference. It is the task of the network
client (i.e. DVR or other client device) to look after the local
time zone setting for the country or zone location, including any
local or national variations to daylight savings time or
equivalent</p>
</div></div></div></div></div></div></div></div></div></div>
                                                       <div class="prod-description">
							<ul class="tabset">
								<li>
									<a class="tab   " href="#tab1">
										<span class="tab-left">
											<span class="tab-right">Key technical features</span>

										</span>
									</a>
								</li>
								<li>
									<a class="tab  " href="#tab2">
										<span class="tab-left">
											<span class="tab-right">Applications</span>
										</span>

									</a>
								</li>
								<li>
									<a class="tab  " href="#tab3">
										<span class="tab-left">
											<span class="tab-right">Product codes</span>
										</span>
									</a>

								</li>
								<li>
									<a class="tab  active" href="#tab4">
										<span class="tab-left">
											<span class="tab-right">Documentation</span>
										</span>
									</a>
								</li>

							</ul>
							<div class="tabs-content">
								<div class="tab" id="tab1" style="display: none;">
									<div class="prod-specification">
										<p><span class="threeH">Time Source</span></p>

<dl>
<dd>GPS Satellite</dd>
</dl>

<p><span class="threeH">Protocol</span></p>

<dl>
<dd>NTP Stratum 1 Time Server</dd>
</dl>

<p><span class="threeH">Accuracy</span></p>

<dl>
<dd>Ethernet NTP ±100ms overall</dd>

<dd>GPS source ±0.1µs</dd>
</dl>

<p><span class="threeH">Antenna</span></p>

<dl>
<dd>GPS sensor on 3m cable (included)</dd>
</dl>

<p><span class="threeH">Connectivity</span></p>

<dl>
<dd>10/100BaseT Ethernet, RJ45</dd>
</dl>

<p><span class="threeH">Status indicators</span></p>

<dl>
<dd>Green LED - long pulse : OK; short pulse : no lock</dd>

<dd>Amber LED - network connectivity</dd>
</dl>

<p><span class="threeH">Power</span></p>

<dl>
<dd>12V DC External power supply (included)</dd>

<dd>Power consumption 0.9W</dd>
</dl>

<p><span class="threeH">Dimensions</span></p>

<dl>
<dd>W : 67mm x D : 92mm x H : 33mm</dd>

<dd>( W : 86mm with wall mounting brackets )</dd>
</dl>

<p><span class="threeH">Environmental</span></p>

<dl>
<dd>Operating temperature -15C to 75C (5F to 125F)</dd>

<dd>Relative humidity 95% non-condensing</dd>
</dl>
									</div> 
								</div>
								<div class="tab" id="tab2" style="display: none;">
									
								</div>
								<div class="tab" id="tab3" style="display: none;">
									<table border="0" style="width: 450px;">
<tbody>
<tr>
<td>VTN-TN</td>
<td>TIMENET GPS NTP time server with indoor antenna<br>
</td>
</tr>

<tr>
<td>VTN-TN-XA</td>
<td>TIMENET GPS NTP time server with outdoor antenna<br>
</td>
</tr>

<tr>
<td>VTN-GPS</td>
<td>TIMENET GPS coordinate and NTP time server<br>
</td>
</tr>
</tbody>
</table>

<p>&nbsp;</p>

<p>All models include a country-independent power supply unit</p>
								</div>
								<div class="tab" id="tab4" style="display: block;">
                                                                                  <p><a title="PDF file, opens in new window. Right-click to download." target="_blank" href="/media/1169/timenet datasheet v1.0.pdf">TIMENET
Datasheet</a></p>

<p><a title="PDF file, opens in new window. Right-click to download." target="_blank" href="/media/1172/timenet flyer.pdf">TIMENET
Promotional Flyer</a></p>

<p><a title="PDF file, opens in new window. Right-click to download." target="_blank" href="/media/407/timenet manual v1.0.pdf">TIMENET
User Manual</a><br>
<br>
<a title="MS Word file, opens in new window. Right-click to download." target="_blank" href="/media/376/timenet a&amp;e specification v1.2.doc">
TIMENET A&amp;E Specification</a></p>

<p><a title="PDF file, opens in new window. Right-click to download." target="_blank" href="/media/434/the%20importance%20of%20accurate%20time%20for%20video%20surveillance.pdf">Article:
The Importance of Accurate Time for video</a></p>

<p><a title="ZIP archive. Click to download." href="/media/417/timenet.zip">TIMENET Software
Utility</a></p>
								</div>
							</div>						
<?php } ?>
                        </div>