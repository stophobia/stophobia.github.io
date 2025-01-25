<?
	if($row_member[Mlevel] > "8") {
		echo "<body leftmargin='0' topmargin='0'>";
	}
	else {
		if($row_setup[tableloc] == "left") echo "<body leftmargin='2' topmargin='0'>";
		else echo "<body leftmargin='0' topmargin='0'>";
	}
?>