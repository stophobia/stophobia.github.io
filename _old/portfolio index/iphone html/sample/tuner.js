// Init

Object.prototype.show = function()
{
	this.style.display = 'block';
}

Object.prototype.hide = function()
{
	this.style.display = 'none';
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

function flip()
{
	if (document.getElementById('flip').src == 'images/flipguitar.png')
		document.getElementById('flip').src = 'images/fliptone.png';
	else
		document.getElementById('flip').src = 'images/flipguitar.png';
}

function scrollToTop()
{
	window.scrollTo(0, 1);
}