var objMethods = {
    "login": {
        handleAction: handleLogInResponse        
    },
    "logout": {
        handleAction: handleLogOutResponse
    },
    "users": {
        handleAction: handleUsersResponse
    }
}
$(document).ready(function(){
    console.log("im ready");
    initSelectors();
});

function initSelectors() {
    $("#login-btn").on("click", handleLogIn);
    $("#logout-btn").on("click", handleLogOut);

    //if url is list get all the list of users
    //The pop() method removes the last element of an array, and returns that element.
    if(window.location.href.split("/").pop() == "list.php") { 
        handleUsers(); 
    }
}

/*
* Handle Events
*/

function handleLogIn() {    
    ajaxCall({
        url: "api/post/Auth.php",
        type: "POST", 
        dataType: "json",
        data: {
            username: $("#username").val(),
            password: $("#password").val(),
            isChecked: $("#remember-me").prop('checked'),
        }
    }, "login");
}

function handleLogOut() {    
    ajaxCall({
        url: "api/delete/Auth.php",
        type: "DELETE"        
    }, "logout");
}

function handleUsers() {    
    ajaxCall({
        url: "api/get/Users.php",
        type: "GET", 
        dataType: "json",     
    }, "users");
}

/*
* Handle Events Response
*/

function handleLogInResponse(data, textStatus, jqXHR) {     
    if(data.status != 200) {
        //TODO Error messages
    } else {
        window.location = "list.php"
    }
}

function handleLogOutResponse(data, textStatus, jqXHR) {    
    if(data.status != 200) {
        //TODO Error messages
    } else {
        window.location = "login.php"
    }
}

function handleUsersResponse(data, textStatus, jqXHR) {    
    if(data.status != 200) {
        //TODO Error messages
    } else {
        //build tables
        buildTable(data.data);
    }
}

/*
* commiter functions
*/

function buildTable(data) {
    $("#users-table").append('<tbody>')
    data.forEach(function(user) {
        $("#users-table").append(`<tr><td> ${user.firstName} ${user.lastName} </td> <td> ${user.group} </td></tr>`)
    });
    
}

/**
 * Util functions
 */
function closeAllNotifications() {

}

function ajaxCall(object, action) {	
	console.log('ajax call');
	$.ajax(object)
	.done(objMethods[action].handleAction)
	.fail(function(jqXHR, textStatus, errorThrown) {		
        //TODO Error messages
	});
}

