function check_empty() {
if (document.getElementById('name').value == "" || document.getElementById('email').value == "" || document.getElementById('msg').value == "") {
alert("Fill All Fields !");
} else {
document.getElementById('form').submit();
alert("Form Submitted Successfully...");
}
}

//Function To Display Popup
function div_show() {
document.getElementById('greyOut').style.display = "block";
}

$(".update").click(function(e) {
		        e.preventDefault();
				document.getElementById('greyOut').style.display = "block";
});

//Function to Hide Popup
function div_hide(){
document.getElementById('greyOut').style.display = "none";
}