<?php #mantzmusic.com/mixing.php main content
	require ('./stuff/config.php');
	$page_title="Mantz Music - Get Quote";
	include ('./includes/header.php');
?>
<script>
	function tglOL() {
		var el = document.getElementById("onLocationType");
		el.style.display = (el.style.display != 'inline' ? 'inline' : 'none');
	}
	function tglMT() {
		var el = document.getElementById("olMics");
		el.style.display = (el.style.display != 'inline' ? 'inline' : 'none');
	}
	function tglSR() {
		var el = document.getElementById("studioRecording");
		el.style.display = (el.style.display != 'inline' ? 'inline' : 'none');
	}
	function tglMx() {
		var el = document.getElementById("mixing");
		el.style.display = (el.style.display != 'inline' ? 'inline' : 'none');
	}
	function tglMs() {
		var el = document.getElementById("mastering");
		el.style.display = (el.style.display != 'inline' ? 'inline' : 'none');
	}
</script>
<h1>Get an Instant Quote</h1>
<form name="quote" action="./quote.php" method="POST">
    <h3>What can we help you with?</h3><p>Select all that apply</p>
      	<p>
            <label>
            <input type="checkbox" name="serviceTypeOL" value="On-Location" id="stOL" onClick="tglOL()">
            On-location Recording (Live)</label>
            <br>
            <label>
            <input type="checkbox" name="serviceTypeSR" value="Studio Recording" id="stSR" onClick="tglSR()">
            Studio Recording</label>
            <br>
            <label>
            <input type="checkbox" name="serviceTypeMx" value="Mixing" id="stMx" onClick="tglMx()">
            Mixing</label>
            <br>
            <label>
            <input type="checkbox" name="serviceTypeMs" value="Mastering" id="stMs" onClick="tglMs()">
            Mastering</label>
            <br>
      	</p>
  	<!----------- On-location Recording Section ------------>
  <div id="onLocationType">
  <h3>On-Location Recording</h3>
  <h4>What type of On-Location Recording do you prefer?</h4>
        <p>
            <label>
              <input type="radio" name="olType" value="2Track" id="ol2T">
              2-Track - <em>This is the best option for acoustic ensembles such as wind ensembles, orchestras, and choirs.</em></label>
            <br>
            <label>
              <input type="radio" name="olType" value="Multitrack" id="olMt" onClick="tglMT()">
              Multitrack - <em>This is the option to choose if P.A. feeds or spot mic's will be mixed into the sound.</em></label>
            <br>
        </p>
    </div> <!--End onLocationType-->
    <div id="olMics">
	<h3>How many seperate mics/inputs do you need for your multitrack recording?</h3>
    	<select name="micInputs" id="micInputs">
    	  <option value="3-4">3-4</option>
    	  <option value="5-8">5-8</option>
    	  <option value="9-16">9-16</option>
    	</select>
   	</div> <!--End olMics-->
	<!---------- Studio Recording Section ---------->
    <div id="studioRecording">
    <h3>Studio Recording</h3>
    <h4>How many days of studio recording are you looking for?</h4>
    	<label>
        	<input name="studioDays" type="text" id="studioDays" size="10" maxlength="2">
        </label>
    <p>(1 day includes up to 10 hours of engineering time in a single session. You are responsible for booking the studio. This quote is for engineering only.)</p>
    
    <h3>What is the name of the studio where the session(s) will take place?</h3>
    	<label>
        	<input name="studioName" type="text" id="studioName" size="40" maxlength="60">
        </label>
  	</div> <!--End studioRecording-->
    <!---------- Mixing Section ---------->
    <div id="mixing">
    <h3>Mixing</h3>
    <h4>How many songs do you need mixed?</h4>
    	<label>
        	<input name="mixSongs" type="text" id="mixSongs" size="10" maxlength="2">
		</label>
                    
 	<h3>What is the average track count of your songs?</h3>
    	<select name="trackCount" id="trackCount">
            <option value="16orless">16 or less</option>
            <option value="17-24">17-24</option>
            <option value="25-48">25-48</option>
            <option value="48-96">48-96</option>
            <option value="96ormore">More than 96</option>
    	</select>
   	</div><!-- End mixing-->
    <!---------- Mastering Section ---------->
    <div id="mastering">
    <h3>Mastering</h3>
    <h4>How many songs do you need mastered?</h4>
    	<label>
        	<input name="masterSongs" type="text" id="masterSongs" size="10" maxlength="2">
       	</label>
        
  	<h3>What is the total duration of the recording?</h3>
    	<label>
        	<input name="mastMinutes" type="text" id="mastMinutes" size="10" maxlength="3">Minutes
       	</label>
  	</div><!-- End mastering-->
	<input type="submit">
    
</form>
<?php
	include ('./includes/footer.php');
?>
