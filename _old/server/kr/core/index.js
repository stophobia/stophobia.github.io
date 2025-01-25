$(function() {
	$("#license", this).toggle("license");
	$("#help", this).click(function() {
		$("#example").toggle("example");
	});
});

function checkPass(t) {
	if(!t.elements['corePass'].value) {
		alert('비밀번호를 입력해 주세요.');
		t.elements['corePass'].focus();
		return false;
	}
	return true;
}