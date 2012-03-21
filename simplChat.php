<?php
// Note:
// This page requires write permission by the web server.
// After chown, this file will be LOCKED to editing except by root or _www
// So, make a copy of this script before setting permissions!
//
// To set permissions for this file on a Mac - cd to folder containing script:
// If using default settings in httpd.conf, _www is user and group for apache:
//
// $ sudo chown -R _www:_www simplChat.php


// PARAMETERS
//
// title of this chat page & script
constant($CHAT_TITLE= "PH(Public House)");//$CHATTITLE= "php simple chat"; // original name
constant($MAX_MSGS=10); // MAX_MSGS + 1 will scroll off the bottom forever
constant($REFRSH_RATE=7); // seconds for every page refresh


// Set up cookie, and prepare message log for display in HTML

//define("URL", "http://あなたの設置したPHPファイルのURL"); // legacy code
define("URL", "./simplChat.php");
define("TIME", time());
define("__THIS_FILE__", file_get_contents(__FILE__));
define("__THIS_SCRIPT__", substr(__THIS_FILE__, 0, strpos(__THIS_FILE__, "__"
	. "halt_compiler();") + 19));

$logs = explode("\n", substr(__THIS_FILE__, strpos(__THIS_FILE__, "__"
	. "halt_compiler();") + 19));
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0) {
    if (isset($_POST['text']) && !empty($_POST['text'])
        && isset($_POST['name']) && !empty($_POST['name'])) {
        setcookie('name', $_POST['name']);

	if(count($logs) > $MAX_MSGS) {
		$logs_original = array_slice($logs, count($logs) - $MAX_MSGS);
	    } else {
		$logs_original = $logs;
	    }

	// sheesh, too clever for readability
	// appears to be setting up each log entry,
	// or throwing an error to the browser
        if (!file_put_contents(__FILE__, __THIS_SCRIPT__
		. join("\n", $logs_original)
		. str_replace(array("\t", "\n", "\r"), "", $_POST['name'])
		. "\t"
		. str_replace(array("\t", "\n", "\r"), "", $_POST['text'])
		. "\t" . TIME . "\n", LOCK_EX)) {
            echo "failed to write / please set permission 666 this file.<br />";
            exit;
        }
    }
    header("Location: " . URL);
}
else {
    $name = isset($_COOKIE['name']) ? $_COOKIE['name'] : "";
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<meta name="description" content="simple PHP chat script" />
	<meta http-equiv="refresh" content="<?php echo "$REFRSH_RATE"?>" />
	<title><?php echo "$CHAT_TITLE"?></title>
	<!-- replace with external CSS if it gets more complex -->
    	<style type="text/css">
    	    body {
    		font-size: 18px;
    		font-family: "sans serif";
    		background: black;
    		color: lightslategrey;}
    	    a {color: mintcream;}
    	    h2 {color: greenyellow;}
    	    strong {color: forestgreen;}
    	</style>
        </head>
        <body onload="document.getElementById('text-message').focus();">
	    <h1><?php echo "$CHAT_TITLE"?></h1>
    	    <form method="post">
    		name : <input type="text" size="10" name="name"
			      value="<?php
			      echo htmlspecialchars($name, ENT_QUOTES); ?>" />
		<br />
    		message : <input type="text" size="50" name="text"
				 value="" id="text-message" />
		<input type="submit" value="Send / Reload" /><br />
    	    </form>
    	    <h2>chat log</h2>
    	    <div style="color: #ccc">
		    <?php
		    foreach (array_reverse($logs) as $m) {
			if (!empty($m)) {
			    list($log_name, $log_message, $log_date)
				    = explode("\t", $m);
			    // &#8212; is an em dash
			    echo '<strong>'
			    . htmlspecialchars($log_name, ENT_QUOTES)
			    . "</strong> said :  "
			    . htmlspecialchars($log_message, ENT_QUOTES)
			    . " <em> &#8212; " . date("Y-m-d H:i:s", $log_date)
			    . " </em><br />\n";
			}
		    }
		    ?>
    	    </div>
<div style="border-top: solid 2px lightslategrey;
     margin-top: 5px;
     padding-top: 3px;
     font-size: 68%;">
    "<a href="http://gist.github.com/33390">
	    <?php echo "$CHAT_TITLE" ?>
        </a>" powered by
        <a href="http://d.hatena.ne.jp/sotarok/">sotarok</a> with
        <a href="http://nequal.jp">nequal</a>
</div>
	    <!-- A PHP nav bar that uses CSS could be useful as an include -->
	    <p><a href="./index.php">Squire (Home)</a></p>
</body>
</html>
<?php
}
exit;
__halt_compiler();
shmoo	blibitty	1332305397
a_guy	humina	1332305530
shmoo	trying again	1332305717
someone	yet another test	1332305779
George	Ok?	1332305928
