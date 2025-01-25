// Init

var items = [];
var addCol = null;

//// Housekeeping

String.prototype.trim = function()
{
	return this.replace(/^\s+|\s+$/g,"");
}

String.prototype.strip = function()
{
	return this.replace(/(<([^>]+)>)/ig, '').replace('>','').replace('<','');
}

String.prototype.kosherize = function()
{
	var allowed = ' _-,.?()+#%*!abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

	var o = '';
	for (i = 0; i < this.length; i++) {
		c = this.charAt(i);
		if (allowed.indexOf(c) > -1)
			o += c;
	}
	return o;
}

String.prototype.space = function()
{
	return this.replace(/_/g, ' ');
}

Object.prototype.show = function()
{
	this.style.display = 'block';
}

Object.prototype.hide = function()
{
	this.style.display = 'none';
}

Object.prototype.destroy = function()
{
	this.parentNode.removeChild(this);
}

function preloadImages()
{
	imgAdd = new Image();
	imgAdd.src = '../apps/images/actions/add.png';
	imgAdded = new Image();
	imgAdded.src = '../apps/images/actions/added.png';
	imgArrow = new Image();
	imgArrow.src = '../apps/images/actions/arrow3.png';

	imgBg4 = new Image();
	imgBg4.src = '../apps/images/bg/bg-top-white.png';
	imgBg5 = new Image();
	imgBg5.src = '../apps/images/bg/bg-white-to-black.png';

	imgBtna = new Image();
	imgBtna.src = '../apps/images/controls/btn-right-gray.png';
	imgBtna1 = new Image();
	imgBtna1.src = '../apps/images/controls/btn-left-gray.png';
	imgBtnb = new Image();
	imgBtnb.src = '../apps/images/controls/btn-right-blue.png';
	imgBtnb1 = new Image();
	imgBtnb1.src = '../apps/images/controls/btn-left-blue.png';
	imgBtnc1 = new Image();
	imgBtnc1.src = '../apps/images/controls/btn-back-gray.png';
	imgBtndMid = new Image();
	imgBtndMid.src = '../apps/images/controls/bm-mid-gray.png';
	imgBtndLeft = new Image();
	imgBtndLeft.src = '../apps/images/controls/bm-left-gray.png';
	imgBtndRight = new Image();
	imgBtndRight.src = '../apps/images/controls/bm-right-gray.png';

	imgCheck1 = new Image();
	imgCheck1.src = '../apps/images/actions/check1.png';
	imgCheck1 = new Image();
	imgCheck1.src = '../apps/images/actions/check2.png';
	imgDelete = new Image();
	imgDelete.src = '../apps/images/actions/del.png';

	imgSpacer = new Image();
	imgSpacer.src = '../apps/images/spacer.png';
}

function scrollToTop()
{
	window.scrollTo(0, 1);
}

// get category name from color
function getCat(color)
{
	for (var i = 0; i <= cats2cols.length; i++)
	{
		if (cats2cols[i] != null && cats2cols[i][0] == color)
		{
			return cats2cols[i][1];
		}
	}
	return false;
}

//// Item functions

function item(id, name, cat, checked, custom, active)
{
	this.id = id;
	this.name = name;
	this.cat = cat;
	this.checked = checked;
	this.custom = custom; // typed item?
	this.active = active;  // show in list? (false = now shown, but still saved to cookie)
}

function reset(a)
{
	var t = [];
	for (var i = 0; i <= a.length; i++)
	{
		if (a[i] != null)
			t[t.length] = new item(i, a[i].name, a[i].cat, a[i].checked, a[i].custom, a[i].active);
	}
	return t;
}

function highestItemId()
{
	h = -1;
	if (items.length > 0)
	{
		for (var i = 0; i <= items.length; i++)
		{
			if (items[i] != null && items[i].id > h)
				h = items[i].id;
		}
	}
	return h;
}

function get(name)
{
	for (var i = 0; i <= items.length; i++)
	{
		if (items[i] != null && items[i].name == name)
		{
			return items[i];
		}
	}
	return false;
}

function add(name, cat, checked, custom, active)
{
	checked = (checked == null ? false : checked);
	custom =  (custom  == null ? false : custom);
	active =  (active  == null ? true : active);

	var a = get(name);
	if (a)
	{
		if (a.active)
		 	// already there and active; can't add
			return false;
		else
		{
			// in items, but inactive; activate
			if (items[a.id] != null && !items[a.id].active)
			{
				items[a.id].active = true;
			}
		}
	}
	else
	{
		// not in items at all; add
		items[items.length] = new item(items.length, name, cat, checked, custom, active);
		return true;
	}
}

function _action(id, checkOnly)
{
	var it;
	if (it = document.getElementById('i' + id))
	{
		// it's an existing list item
		if (it.className.indexOf('del') > -1)
		{
			if (checkOnly != true)
				_del(id);
		}
		else
		{
			check(id);
			refresh();
		}
	}
}

function _delSaved(id)
{
	if (items[id].custom)
		items.splice(id, 1);
	refresh();
	_goSaved();
	_editSaved();
}

function del(id)
{
	if (items[id].custom)
		items[id].active = false; // don't delete custom items; just don't show them if deleted
	else
		items.splice(id, 1);
}

// toggles between checked and unchecked
function check(id)
{
	if (items[id] != null)
	{
		items[id].checked = (items[id].checked ? false : true); // toggle check
	}
	else
		return false; // couldn't check
}

function sortByCat(a, b) {
    var x = a.cat;
    var y = b.cat;
    if (x < y)
    	return -1;
    else if (x > y)
    	return 1;
    else
    	return 0;
}

//// Cookies

function _getCookie()
{
	//document.getElementById('dump').innerHTML = document.cookie;
	if (document.cookie.indexOf('items=') > -1)
	{
		var p = unescape(document.cookie).substring(6).split('\\'); // 6 = end of 'items='
		for (var i = 0; i < p.length; i++)
		{
			var a = p[i].split('&');
			add(a[1], a[2], (a[3] == 'true'), (a[4] == 'true'), (a[5] == 'true'));
		}
	}
	_goHome();

}

// Events

function refresh()
{
	//items.sort(sortByCat);
	items = reset(items);

	document.getElementById('list').innerHTML = '';
	document.getElementById('saved').innerHTML = '';

	var customExists = false;

	for (var i = 0; i < items.length; i++)
	{
		var id = i;
		var name = items[i].name;
		var color = items[i].cat;
		var custom = items[i].custom;
		var active = items[i].active;
		var checkString = items[i].checked ? ' checked ' : '';

		if (active)
		{
			// SHOPPING LIST
			document.getElementById('list').innerHTML += '<div class="' + color + checkString + ' actionable item" id="i' + id + '"><div class="actionCont"><div class="arrowCont"><img class="action" src="../apps/images/spacer.png" border="0" align="top"  onclick="_action(' + id + ')" /><a href="javascript:_action(' + id + ', true)">' + name.replace('_', ' ') + '</a></div></div></div>\n';

			// CATEGORIES
			var l;
			if (l = document.getElementById('l' + name.replace(/ /g, '_')))
			{
				// it's an existing list item
				if (l.className.indexOf(' added ') < 0)
					l.className += ' added ';
			}

			// SAVED - add active item
			if (custom)
			{
				document.getElementById('saved').innerHTML += '<div class="added item" id="l' + id + '"><div class="actionCont"><div class="arrowCont"><img class="action" src="../apps/images/spacer.png" border="0" align="top" onclick="_delSaved(' + id + ')" /><a href="#">' + name.replace('_', ' ') + '</a></div></div></div>\n';
				customExists = true;
			}
		}
		else if (custom)
		{
			// SAVED - add inactive item
			document.getElementById('saved').innerHTML += '<div class="' + color + ' add item" id="l' + id + '"><div class="actionCont"><div class="arrowCont"><img class="action" src="../apps/images/spacer.png" border="0" align="top" onclick="_delSaved(' + id + ')" /><a href="javascript:_addSaved(' + id + ', \'' + name + '\', \'' + color + '\')">' + name.replace('_', ' ') + '</a></div></div></div>\n';
			customExists = true;
		}

	} // end items loop

	// Add clear list item to main list
	document.getElementById('list').innerHTML += '<div id="btnClearList" class="clear x item" style="display:none"><div class="actionCont"><div class="arrowCont"><a href="javascript:_clearList()">Clear shopping list</a></div></div></div>';

	// Add email link
	document.getElementById('list').innerHTML += '<div id="btnEmail" class="clear more item" style="display:block"><div class="actionCont"><div class="arrowCont"><a href="javascript:_goEmail()">Email shopping list&thinsp;&hellip;</a></div></div></div>';

	// saved list
	if (!customExists)
		document.getElementById('saved').innerHTML += '<div class="infoText"><span>You have no saved items.</span><br /><br /> <a href="javascript:_goEnter();">Go enter some!</a></div>';
	else
		document.getElementById('saved').innerHTML += '<div id="btnClearSavedList" class="clear x item" style="display:none"><div class="actionCont"><div class="arrowCont"><a href="javascript:_clearSaved()">Clear saved items</a></div></div></div>';

	if (items.length > 0)
		_updateCookie();
	else
		_clearCookie();

	refreshTitleCount();

	// debug
/*
	document.getElementById('dump').innerHTML = '';
	for (var j = 0; j < items.length; j++)
	{
		document.getElementById('dump').innerHTML += 'id: ' + items[j].id + '; name: ' + items[j].name + '; active: ' + items[j].active + '; custom: ' + items[j].custom + '; checked: ' + items[j].checked + '<hr>';
	}
*/
}

function itemsLeft()
{
	var c = 0;
	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active && !items[i].checked)
			c++;
	}
	return c;
}
function itemsTotal()
{
	var c = 0;
	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active)
			c++;
	}
	return c;
}

function _updateCookie()
{
	// turn items array into flat string
	var c = '';
	for (var i = 0; i < items.length; i++)
	{
		c += i + '&' + items[i].name + '&' + items[i].cat + '&' + items[i].checked + '&' + items[i].custom + '&' + items[i].active;
		if (i != items.length - 1)
			c += '\\';
	}

	// clear cookie, then write it
	_clearCookie();
	var date = new Date();
	date.setTime(date.getTime()+30*24*60*60*1000); // 30 days
	document.cookie  = 'items=' + escape(c) + '; expires=' + date.toGMTString() + "; path=/";
}

function _clearCookie()
{
	var date = new Date();
	date.setTime(date.getTime()-1);
	document.cookie  = 'items=; expires=' + date.toGMTString() + "; path=/";
	document.cookie  = 'prev=; expires=' + date.toGMTString() + "; path=/";
}

function refreshTitleCount()
{
	i = itemsTotal();
	l = itemsLeft();

	document.getElementById('title').innerHTML = 'OneTrip' + (l > 0 ? ' (' + l + ')' : '');
}

function hideTitle()
{
	document.getElementById('title').hide();
}
function _goHome()
{
	addCol = null;

	// toolbar
	_hideAllButtons();
	document.getElementById('btnAdd').show();
	document.getElementById('btnEdit').show();
	document.getElementById('enter').hide();
	document.getElementById('saved').hide();
	document.getElementById('cats').hide();
	document.getElementById('enter').hide();
	document.getElementById('email').hide();
	_hideAllCats();
	_view();

	refresh();
	_checkEmptyList();

	document.getElementById('list').show();

	scrollToTop();
}

function _goAdd()
{
	//_view();

	// toolbar
	_hideAllButtons();
	document.getElementById('btnHome').show();
	hideTitle();
	document.getElementById('title2').show();
	document.getElementById('title2').innerHTML = 'Categories';

	document.getElementById('list').hide();
	document.getElementById('cats').show();

	scrollToTop();
}

function _showCat(catName)
{
	// toolbar
	_hideAllButtons();
	document.getElementById('cats').hide();
	document.getElementById('btnBack').show();
	document.getElementById('title2').show();
	document.getElementById('title2').innerHTML = catName.replace(/_/g, ' ').substring(1);

	_hideAllCats();

	if (cat = document.getElementById(catName))
		cat.show();

	hideTitle();

	scrollToTop();
}


function _goEnter(addCat)
{
	if (addCat != null)
		addCol = addCat;

	// toolbar
	_hideAllButtons();
	document.getElementById('btnBack').show();
	document.getElementById('title2').show();
	document.getElementById('title2').innerHTML = 'Type it in';

	hideTitle();

	_hideAllCats();
	document.getElementById('list').hide();
	document.getElementById('cats').hide();
	document.getElementById('enter').show();

	document.getElementById('enterNote').hide();

	if (addCol != null)
	{
		catName = getCat(addCol).substring(1).replace(/_/g, ' ');
		document.getElementById('enterLabel').innerHTML = 'Add to ' + catName;
		document.getElementById('btnBack').innerHTML = '<div>' + catName + '</div>';
	}
	else
	{
		document.getElementById('enterLabel').innerHTML = 'Add to shopping list';
		document.getElementById('btnBack').innerHTML = '<div>Categories</div>';
	}

	_blurEnter();
	scrollToTop();
}

// go back to category view
function _goBack()
{
	if (addCol != null)
	{
		// we came here from a 'type it in' item in a category
		document.getElementById('enter').hide();
		document.getElementById('btnBack').innerHTML = '<div>Categories</div>';
		_showCat(getCat(addCol));
		addCol = null;
		return;
	}

	// toolbar
	_hideAllButtons();
	document.getElementById('btnHome').show();
	document.getElementById('title2').show();
	document.getElementById('title2').innerHTML = 'Categories';

	hideTitle();

	_hideAllCats();
	document.getElementById('cats').show();
	document.getElementById('enter').hide();

	scrollToTop();

	addCol = null;
}

function _goSaved()
{
	// toolbar
	_hideAllButtons();
	document.getElementById('btnBack').show();
	document.getElementById('btnEditSaved').show();
	document.getElementById('btnEditingSaved').hide();
	document.getElementById('title2').innerHTML = 'Saved items';
	document.getElementById('title2').show();

	_hideAllCats();

	document.getElementById('saved').show();
	document.getElementById('list').hide();
	document.getElementById('cats').hide();

	if (cl = document.getElementById('btnClearSavedList'))
		cl.hide();

	hideTitle();
	scrollToTop();
}

function _goEmail()
{
	// toolbar
	_hideAllButtons();
	document.getElementById('btnHome').show();
	document.getElementById('list').hide();
	document.getElementById('title').hide();
	document.getElementById('title2').show();
	document.getElementById('title2').innerHTML = 'Email';
	_hideAllCats();

	document.getElementById('email').show();
	scrollToTop();
}

function _hideAllButtons()
{
	document.getElementById('btnAdd').hide();
	document.getElementById('btnEdit').hide();
	document.getElementById('btnEditing').hide();
	document.getElementById('btnBack').hide();
	document.getElementById('btnHome').hide();
	document.getElementById('btnEditSaved').hide();
	document.getElementById('btnEditingSaved').hide();
	document.getElementById('title2').hide();
	document.getElementById('editSavedNote').hide();

	var c;
	if (c = document.getElementById('btnClearList'))
		c.hide();
	var e;
	if (e = document.getElementById('btnEmail'))
		e.hide();
}

function _checkEmptyList()
{
	var emptyText = '<div class="infoText"><div>Your shopping list is empty. Click the + button above to start adding items.</div><div style="margin:13px 0px 18px 0px"><span>OneTrip shopping list by <a href="http://mrgan.tumblr.com">Neven Mrgan</a></span></div><table class="btnMid" border="0" cellpadding="0" cellspacing="0" onclick="document.location.href=\'http://onetrip.org/apps/?pass\';"><tr><td class="midLeft"></td><td class="midMid">More web apps</td><td class="midRight"></td></tr></table></div>';

	var existActiveItems = false;
	// check if we have any visible items at all
	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active)
		{
			existActiveItems = true;
			break;
		}
	}

	if (!existActiveItems)
	{
		// empty list?
		document.getElementById('btnEdit').hide();
		var c;
		if (c = document.getElementById('btnClearList'))
			c.hide();
		document.getElementById('btnEditing').hide();
		document.getElementById('title').show();
		document.getElementById('list').innerHTML = emptyText;
	}
}

function _blurEnter(itemName)
{
	document.getElementById('entered').value = '';
}

function _addSaved(id, itemName, itemColor)
{
	if (l = document.getElementById('l' + id))
	{
		if (l.className.indexOf(' del ') < 0)
			_add(itemName, itemColor);
	}
}

function _add(itemName, itemColor)
{
	a = get(itemName);
	if (!a || (a.custom && !a.active))
	{
		add(itemName, itemColor);
		refresh();
	}
	else
	{
		_del(a.id, true);
	}
}

function _del(id, dontEdit)
{
	// enable menu item
	if (!items[id].custom)
	{
		if (l = document.getElementById('l' + items[id].name.replace(/ /g, '_')))
		{
			l.className = l.className.replace(/added/g, '');
		}
	}
	else
	{
		// it's custom
		if (l = document.getElementById('l' + id))
		{
			l.className = l.className.replace(/added/g, '');
		}
	}

	del(id);
	refresh();
	if (!dontEdit || dontEdit == null)
		_edit();
}


function _addEntered()
{
	var u = document.getElementById('entered').value.trim().strip().kosherize();

	if (u != '') // we have something
	{
		// if it exists as a list item, get its real color
		u = u.substring(0, 1).toUpperCase() + u.substring(1); // eggs > Eggs

		var inlist = false;
		if (l = document.getElementById('l' + u.replace(/ /g, '_')))
		{
			// it exists in the list, so get parent's color
			color = l.parentNode.className.substring(0, l.parentNode.className.indexOf(' '));
			inlist = true;
		}
		else
		{
			// it's a brand new item
			if (addCol != null)
				color = addCol;
			else
				color = 'zgold'; // default
		}

		previouslyActive = get(u).active;
		var entered = add(u, color, false, !inlist); // add to list
		if (!entered && previouslyActive)
		{
			document.getElementById('enterNote').innerHTML = '<span>' + u + '</span> already added';
		}
		else
		{
			// not already added
			document.getElementById('enterNote').innerHTML = 'Added <span>' + u + '</span>' + (inlist ? '<br />Pssst... you could have selected that from the list!' : '');
		}
		_blurEnter();
		document.getElementById('enterNote').show();
	}
	else
	{
		document.getElementById('entered').value = '';
		document.getElementById('enterNote').show();
		document.getElementById('enterNote').innerHTML = 'Can\'t add that&thinsp;&hellip;';
	}
	refresh();
}

function _edit()
{
	document.getElementById('btnEditing').show();
	document.getElementById('btnEdit').hide();

	var c;
	if (c = document.getElementById('btnClearList'))
		c.show();

	var e;
	if (e = document.getElementById('btnEmail'))
		e.hide();

	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active)
		{
			it = document.getElementById('i' + i);
			it.className += ' del ';
		}
	}
	_checkEmptyList();
}

function _view()
{
	document.getElementById('btnEditing').hide();
	document.getElementById('btnEdit').show();

	var c;
	if (c = document.getElementById('btnClearList'))
		c.hide();
	var e;
	if (e = document.getElementById('btnEmail'))
		e.show();
	document.getElementById('title').show();

	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active)
		{
			if (it = document.getElementById('i' + i))
				it.className = it.className.replace(/del/g, '');
		}
	}
}

function _editSaved()
{
	document.getElementById('btnEditingSaved').show();
	document.getElementById('btnEditSaved').hide();

	var showNote = false;
	var showClear = false;

	var c;
	if (c = document.getElementById('btnClearSavedList'))
		c.hide();

	for (var i = 0; i < items.length; i++)
	{
		if (items[i].custom)
		{
			if (!items[i].active)
			{
				it = document.getElementById('l' + i);
				it.className = (items[i].active ? '' : items[i].cat) +  ' actionable del item '; // preserve color
				showClear = true;
			}
			else
				showNote = true;
		}
	}

	if (showNote)
		document.getElementById('editSavedNote').show();
	if (showClear)
		c.show();
}

function _viewSaved()
{
	document.getElementById('btnEditingSaved').hide();
	document.getElementById('btnEditSaved').show();

	var c;
	if (c = document.getElementById('btnClearSavedList'))
		c.hide();

	for (var i = 0; i < items.length; i++)
	{
		if (items[i].custom)
		{
			if (it = document.getElementById('l' + i))
				it.className =  (items[i].active ? ' added ' : items[i].cat + ' add ') + ' item '; // preserve color
		}
	}

	document.getElementById('editSavedNote').hide();
}

function _clearList()
{
	// make temp array of items NOT to delete - custom items
	var t = [];
	for (var i = 0; i < items.length; i++)
	{
		if (items[i].custom)
		{
			t.push(items[i]);
			t[t.length - 1].active = false;
		}
		else
		{
			// enable menu item
			if (l = document.getElementById('l' + items[i].name.replace(/ /g, '_')))
			{
				l.className = l.className.replace(/added/g, '');
			}
		}
	}

	items = t;
	_goHome();
}

function _clearSaved()
{
	// make temp array of items NOT to delete - non-custom items
	var t = [];
	for (var i = 0; i < items.length; i++)
	{
		// if it's in the list, we have to keep it there
		if (!items[i].custom || items[i].active) // if it's custom but it's in the list, we have to keep it there
		{
			t.push(items[i]);
		}
	}

	items = t;
	_goHome();
}

function _emailText()
{
	var l = 'Please pick up the following at the store: <br /><br />';
	for (var i = 0; i < items.length; i++)
	{
		if (items[i].active)
		{
			l += '- ' + items[i].name + (items[i].checked ? ' (got it already)' : '') + '<br />';
		}
	}
	l += '<br /> Thanks! <br /><br /> (Sent from http://onetrip.org, a shopping list for your iPhone)';
	document.location.href = 'mailto:?subject=Shopping%20list%20from%20OneTrip&body=' + escape(l);
}

function _emailiPhone()
{
	document.location.href = 'email.php?iphone';
}