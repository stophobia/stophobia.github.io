var fontSize = 15;
function scaleFont(val) {
 var content, lineHeight;
 content = document.getElementById("content");
 if (val > 0) {
  if (fontSize <= 20) {
   fontSize = fontSize + val;
   lineHeight = fontSize+Math.round(1.1*fontSize);
   content.style.fontSize = fontSize + "px";
  }
 } else {
  if (fontSize > 10) {
   fontSize = fontSize + val;
   lineHeight = fontSize+Math.round(1.1*fontSize);
   content.style.fontSize = fontSize + "px";
  }
 }
}