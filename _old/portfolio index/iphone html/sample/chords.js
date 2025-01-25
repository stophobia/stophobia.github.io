aRoots = new Array('C', 'Cs', 'D', 'Ds', 'E', 'F', 'Fs', 'G', 'Gs', 'A', 'As', 'B');
aChords = new Array('maj', 'm', 'dim', 'sus4', '6', '7', '7+', '7b5', '7#9', '9', '11', '13', 'm6', 'm7', 'm7+', 'm7b5');

curRoot = '';
curChord = '';

function switchRoot(note)
{
	// reset all
	for (i = 0; i < aRoots.length; i++)
	{
		rootBtn = document.getElementById('b' + aRoots[i]);
		if (rootBtn.className.indexOf('x') > -1 && aRoots[i] != note) // only those marked x
			rootBtn.className = rootBtn.className.substring(0, rootBtn.className.length - 1); // remove the x
	}
	
	rootBtn = document.getElementById('b' + note);
	if (rootBtn.className.indexOf('x') < 0) // don't set to "x x"
		rootBtn.className = rootBtn.className + ' x';
		
	curRoot = note;
	mark();
}

function switchChord(chord)
{	
	// reset all
	for (i = 0; i < aChords.length; i++)
	{
		chord2 = aChords[i].replace('+', 'qq');
		chord2 = chord2.replace('#', 'zz');
		
		// can't have things like + in an element id
		chordBtn = document.getElementById('c' + chord2);
		if (chordBtn.className.indexOf('x') > -1 && aChords[i] != chord) // only those marked x, and not the one we're doing
			chordBtn.className = chordBtn.className.substring(0, chordBtn.className.length - 1); // remove the x
	}
	
	chord2 = chord.replace('+', 'qq');
	chord2 = chord2.replace('#', 'zz');
		
	chordBtn = document.getElementById('c' + chord2);
	if (chordBtn.className.indexOf('x') < 0) // don't set to "x x"
		chordBtn.className = chordBtn.className + ' x';
	
	curChord = chord;
	mark();
}

function labelFrets(start)
{
	start = parseInt(start);
	s = '';
	for (i = 0; i < 5; i++)
	{
		if (start > 1 && i == 0)
			s += '<div class="bigFret">' + (i+start) + '</div>';
		else
			s += '<div>' + (i+start) + '</div>';
	}
	
	document.getElementById('frets').innerHTML = s;
}	

function mark()
{
	newchord = c[curRoot + '-' + curChord];
	o = ''; //output
	
	lowest = 999;
	highest = 0;
	for (i = 0; i < 6; i++)
	{
		if (newchord[i] != 'x' && newchord[i] != '0')
		{
			if (newchord[i] < lowest)
				lowest = newchord[i];
			if (newchord[i] > highest)
				highest = newchord[i];
		}
	}	
	
	offset = 0;
	if (highest > 5)
	{
		offset = lowest-1;	
	}
			
	for (i = 0; i < 6; i++)
	{				
		
		switch(newchord[i])
		{
			case 'x' :					
				o += '<img class="mark" src="images/no.png" style="position: absolute; top: '+ ((i*26)+3) +'px; left: 14px;" />';
				break;
			case '0' :
				o += '<img class="mark" src="images/open.png" style="position: absolute; top: '+ (Math.round(i*26.2)+1) +'px; left: 0px;" />';
				break;
			default : // a number
				fret = parseInt(newchord[i]) - offset; // offset for when we're not starting on the 1st fret
				//alert(fret);				
				
				o += '<img class="mark" src="images/one.png" style="position: absolute; top: '+ ((i*26.2)+3) +'px; left: '+ (((fret*62)-23)) +'px;" />';
				break;
		}		
	}
	document.getElementById('marks').innerHTML = o;
	
	if (lowest == 0)
		lowest = 1;
	if (highest > 5)	
		labelFrets(lowest);
	else
		labelFrets(1);
}

c = new Array();

c['C-maj'] = '01023x';
c['C-m'] = '34553x';
c['C-dim'] = 'x4543x';
c['C-sus4'] = '36553x';
c['C-6'] = '01223x';
c['C-7'] = '01323x';
c['C-7+'] = '00023x';
c['C-7b5'] = '8x897x';
c['C-7#9'] = 'x3234x';
c['C-9'] = '03323x';
c['C-11'] = '11001x';
c['C-13'] = 'x1221x';
c['C-m6'] = '4121xx';
c['C-m7'] = '34353x';
c['C-m7+'] = '34453x';
c['C-m7b5'] = 'x4343x';
c['Cs-maj'] = '46664x';
c['Cs-m'] = '45664x';
c['Cs-dim'] = '45654x';
c['Cs-sus4'] = '47664x';
c['Cs-6'] = '1211311';
c['Cs-7'] = '46464x';
c['Cs-7+'] = '46564x';
c['Cs-7b5'] = 'x4546x';
c['Cs-7#9'] = 'x4345x';
c['Cs-9'] = 'x4434x';
c['Cs-11'] = '22434x';
c['Cs-13'] = '666989';
c['Cs-m6'] = 'x5324x';
c['Cs-m7'] = '45464x';
c['Cs-m7+'] = '45564x';
c['Cs-m7b5'] = 'x5454x';
c['D-maj'] = '2320xx';
c['D-m'] = '1320xx';
c['D-dim'] = 'x6765x';
c['D-sus4'] = '3320xx';
c['D-6'] = '2020xx';
c['D-7'] = '2120xx';
c['D-7+'] = '2220xx';
c['D-7b5'] = '2110xx';
c['D-7#9'] = 'x6545x';
c['D-9'] = 'x5545x';
c['D-11'] = '33545x';
c['D-13'] = '77545x';
c['D-m6'] = '1020xx';
c['D-m7'] = '1120xx';
c['D-m7+'] = '1220xx';
c['D-m7b5'] = '1110xx';
c['Ds-maj'] = '68886x';
c['Ds-m'] = '67886x';
c['Ds-dim'] = 'x7876x';
c['Ds-sus4'] = '69886x';
c['Ds-6'] = '3101xx';
c['Ds-7'] = '68686x';
c['Ds-7+'] = '68786x';
c['Ds-7b5'] = '3221xx';
c['Ds-7#9'] = 'x7656x';
c['Ds-9'] = '1201xx';
c['Ds-11'] = '44656x';
c['Ds-13'] = '88656x';
c['Ds-m6'] = '2131xx';
c['Ds-m7'] = '67686x';
c['Ds-m7+'] = '67786x';
c['Ds-m7b5'] = 'x7676x';
c['E-maj'] = '001220';
c['E-m'] = '000220';
c['E-dim'] = 'x8987x';
c['E-sus4'] = '002200';
c['E-6'] = '021220';
c['E-7'] = '001020';
c['E-7+'] = '001120';
c['E-7b5'] = '031010';
c['E-7#9'] = 'x8767x';
c['E-9'] = '201020';
c['E-11'] = '55767x';
c['E-13'] = '021020';
c['E-m6'] = '020220';
c['E-m7'] = '000020';
c['E-m7+'] = '000120';
c['E-m7b5'] = 'x8787x';
c['F-maj'] = '112331';
c['F-m'] = '111331';
c['F-dim'] = 'x01321';
c['F-sus4'] = '113311';
c['F-6'] = '112001';
c['F-7'] = '112131';
c['F-7+'] = '112231';
c['F-7b5'] = 'x02121';
c['F-7#9'] = 'x9878x';
c['F-9'] = '110101';
c['F-11'] = 'x13101';
c['F-13'] = '330101';
c['F-m6'] = '131331';
c['F-m7'] = '111131';
c['F-m7+'] = '111231';
c['F-m7b5'] = 'x01121';
c['Fs-maj'] = '223442';
c['Fs-m'] = '222442';
c['Fs-dim'] = 'xx2432';
c['Fs-sus4'] = '224422';
c['Fs-6'] = 'x23112';
c['Fs-7'] = '223242';
c['Fs-7+'] = '223342';
c['Fs-7b5'] = 'x13212';
c['Fs-7#9'] = 'xx2212';
c['Fs-9'] = 'x21212';
c['Fs-11'] = '001212';
c['Fs-13'] = '243242';
c['Fs-m6'] = '242442';
c['Fs-m7'] = '222242';
c['Fs-m7+'] = '222342';
c['Fs-m7b5'] = '012202';
c['G-maj'] = '330023';
c['G-m'] = '333553';
c['G-dim'] = 'xx3543';
c['G-sus4'] = '330033';
c['G-6'] = '030023';
c['G-7'] = '334353';
c['G-7+'] = '334453';
c['G-7b5'] = 'x24323';
c['G-7#9'] = 'x03323';
c['G-9'] = 'x02323';
c['G-11'] = '110023';
c['G-13'] = '000323';
c['G-m6'] = '353553';
c['G-m7'] = '333353';
c['G-m7+'] = '333453';
c['G-m7b5'] = '666343';
c['Gs-maj'] = '445664';
c['Gs-m'] = '444664';
c['Gs-dim'] = 'xx4654';
c['Gs-sus4'] = '446644';
c['Gs-6'] = '111334';
c['Gs-7'] = '445464';
c['Gs-7+'] = '445564';
c['Gs-7b5'] = '8776xx';
c['Gs-7#9'] = 'xx4434';
c['Gs-9'] = 'x43434';
c['Gs-11'] = 'xx6434';
c['Gs-13'] = '465464';
c['Gs-m6'] = 'xx1324';
c['Gs-m7'] = '444464';
c['Gs-m7+'] = '444564';
c['Gs-m7b5'] = '474654';
c['A-maj'] = '02220x';
c['A-m'] = '01220x';
c['A-dim'] = 'x1210x';
c['A-sus4'] = '03200x';
c['A-6'] = '22220x';
c['A-7'] = '02020x';
c['A-7+'] = '02120x';
c['A-7b5'] = '32101x';
c['A-7#9'] = 'xx5545';
c['A-9'] = 'x54545';
c['A-11'] = 'xx7545';
c['A-13'] = '22020x';
c['A-m6'] = '21220x';
c['A-m7'] = '01020x';
c['A-m7+'] = '01120x';
c['A-m7b5'] = '31210x';
c['As-maj'] = '13331x';
c['As-m'] = '12331x';
c['As-dim'] = '02321x';
c['As-sus4'] = '14311x';
c['As-6'] = '13001x';
c['As-7'] = '13131x';
c['As-7+'] = '13231x';
c['As-7b5'] = '03101x';
c['As-7#9'] = '12101x';
c['As-9'] = '11101x';
c['As-11'] = 'xx8656';
c['As-13'] = '33101x';
c['As-m6'] = '32031x';
c['As-m7'] = '12131x';
c['As-m7+'] = '12231x';
c['As-m7b5'] = '02121x';
c['B-maj'] = '24442x';
c['B-m'] = '23442x';
c['B-dim'] = 'x3432x';
c['B-sus4'] = '25422x';
c['B-6'] = '20112x';
c['B-7'] = '24242x';
c['B-7+'] = '24342x';
c['B-7b5'] = '54232x';
c['B-7#9'] = 'x3212x';
c['B-9'] = 'x2212x';
c['B-11'] = '00212x';
c['B-13'] = '44242x';
c['B-m6'] = '20102x';
c['B-m7'] = '23242x';
c['B-m7+'] = '23342x';
c['B-m7b5'] = 'x3232x';