deployQZ();
 
	function deployQZ() {
		var attributes = {id: "qz", code:'qz.PrintApplet.class', 
			archive:'modul/mod_print/qz-print.jar', width:1, height:1};
		var parameters = {jnlp_href: 'modul/mod_print/qz-print_jnlp.jnlp', 
			cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			delete parameters['jnlp_href'];
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
/**
	* Automatically gets called when applet has loaded.
	*/
	function qzReady() {
		// Setup our global qz object
		window["qz"] = document.getElementById('qz');
		var title = document.getElementById("title");
		if (qz) {
			try {
				document.getElementById("content").style.background = "#FFF";
			} catch(err) { // LiveConnect error, display a detailed meesage
				document.getElementById("content").style.background = "#F5A9A9";
				alert("ERROR:  \nThe applet did not load correctly.  Communication to the " + 
					"applet has failed, likely caused by Java Security Settings.  \n\n" + 
					"CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " + 
					"once Oracle has marked that version as outdated, which " + 
					"is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " + 
					"Java version \n          (or)\n  2. Lower the security " + 
					"settings from the Java Control Panel.");
		  }
	  }
	}
	
	/**
	* Returns whether or not the applet is not ready to print.
	* Displays an alert if not ready.
	*/
	function notReady() {
		// If applet is not loaded, display an error
		if (!isLoaded()) {
			return true;
		}
		// If a printer hasn't been selected, display a message.
		else if (!qz.getPrinter()) {
			alert('Silahkan pilih printer terlebih dahulu... "Detect Printer" button.');
			return true;
		}
		return false;
	}
	
	/**
	* Returns is the applet is not loaded properly
	*/
	function isLoaded() {
		if (!qz) {
			alert('Error:\n\n\tPrint plugin tidak berjalan!');
			return false;
		} else {
			try {
				if (!qz.isActive()) {
					alert('Error:\n\n\tPrint plugin is loaded but NOT active!');
					return false;
				}
			} catch (err) {
				alert('Error:\n\n\tPrint plugin is NOT loaded properly!');
				return false;
			}
		}
		return true;
	}
	
	/**
	* Automatically gets called when "qz.print()" is finished.
	*/
	function qzDonePrinting() {
		// Alert error, if any
		if (qz.getException()) {
			alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
			qz.clearException();
			return; 
		}
		
		// Alert success message
		alert('Data berhasil dikirim ke printer "' + qz.getPrinter() + '" untuk di cetak....');
	}

	
	/***************************************************************************
	* Prototype function for finding the closest match to a printer name.
	* Usage:
	*    qz.findPrinter('zebra');
	*    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
	***************************************************************************/
	function findPrinter(name) {
		// Get printer name from input box
		var p = document.getElementById('printer');
		if (name) { p.value = name; }
		
		if (isLoaded()) {
			// Searches for locally installed printer with specified name
			qz.findPrinter(p.value);
			// Automatically gets called when "qz.findPrinter()" is finished.
			window['qzDoneFinding'] = function() {
				var printer = qz.getPrinter();
				if (printer !== null) {
                    return true;
                }
                else {
                    alert('Error:\n\n\tPrinter tidak ditemukan !');
					return false;
                }
				window['qzDoneFinding'] = null;
			};
		}
	}
    	/***************************************************************************
	****************************************************************************
	* *                          HELPER FUNCTIONS                             **
	****************************************************************************
	***************************************************************************/
	function getPath() {
		var path = window.location.href;
		return path.substring(0, path.lastIndexOf("/")) + "/";
	}
	
	/**
	* Fixes some html formatting for printing. Only use on text, not on tags!
	* Very important!
	*   1.  HTML ignores white spaces, this fixes that
	*   2.  The right quotation mark breaks PostScript print formatting
	*   3.  The hyphen/dash autoflows and breaks formatting  
	*/
	function fixHTML(html) {
		return html.replace(/ /g, "&nbsp;").replace(/’/g, "'").replace(/-/g,"&#8209;"); 
	}
	
	/**
	* Equivelant of VisualBasic CHR() function
	*/
	function chr(i) {
		return String.fromCharCode(i);
	}