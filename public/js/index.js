$(document).ready(function(){
    console.log("im ready");
    initSelectors();
});

function initSelectors() {
    $("#login-btn").on("click", handleLogin);
}

/*
* Handle Events
*/

function handleLogin() {
    $.ajax({
        url: "api/post/Auth.php",
        type: "POST", 
        dataType: "json",
        data: {
            username: "yansey",
            password: "ziztemaz"
        }
    }).done( function(response, textStatus, jqXHR) {
        console.log(response);
    }).fail(function(jqXHR, textStatus, errorThrown) {	        	
        console.log(textStatus);
    });
}

function callFunction(params) {	
	var type = params.type;
	delete params.type;
	$.ajax({ url: "", type: "POST", dataType: "json", data: params })
	.done(hybOvenIncubateBC[type].handleAction)
	.fail(function(jqXHR, textStatus, errorThrown) {		
		window.location.href = 'index.jsp';		
	});
}