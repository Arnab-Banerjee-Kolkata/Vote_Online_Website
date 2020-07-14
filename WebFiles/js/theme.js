var switchbtns = document.getElementsByClassName("switchbtn");
var activeSheet = document.getElementById("active-stylesheet");

// Test to see if localStorage already has a value stored
if (localStorage.getItem("lastActiveSheet")) {
     activeSheet.setAttribute("href", localStorage.getItem("lastActiveSheet"));
}

// Assign the event lister to each button
for (var i = 0; i < switchbtns.length; i++) {
  switchbtns[i].addEventListener("click", switchStyle);  
}

// Set the #active-stylesheet to be the light or dark stylesheet
function switchStyle() {
   var selectedSheet = this.getAttribute("data-stylesheet");
   activeSheet.setAttribute("href", selectedSheet);
   localStorage.setItem("lastActiveSheet", selectedSheet);
}
