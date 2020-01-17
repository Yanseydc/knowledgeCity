var pageNo = 0;
var totalPages = 0;
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
        url: "api/get/Users.php?pageNo=0",
        type: "GET", 
        dataType: "json",     
    }, "users");
}

function handleNextEvent() {
    //parse pageNo value to int, I added +1 'cause the visual pageNo to the user its +1 at the actual value that I'm managing in the code.
    pageNo = parseInt(pageNo);

    //if true, can paginate to the next one
    if(pageNo < totalPages-1) {
        //show the button after the first movement of page
        $("#previous").show();
        //store the selectors into variables
        var current = $("#page-list .active");
        var next = $("#page-list .active").next();

        //remove active class from the current and add it to the next selector.
        current.removeClass("active");
        next.addClass("active");

        ajaxCall({
            url: `api/get/Users.php?pageNo=${pageNo+1}`,
            type: "GET", 
            dataType: "json",     
        }, "paginate");
    }   
}

function handlePreviousEvent() {
    //parse pageNo value to int, I added +1 'cause the visual pageNo to the user its +1 at the actual value that I'm managing in the code.
    pageNo = parseInt(pageNo);
    if(pageNo > 0) {
        //if there is not more elements to go back, hide the button
        if(pageNo-1 == 0) {            
            $("#previous").hide();
        }
        //store the selectors into variables
        var current = $("#page-list .active");
        var previous = $("#page-list .active").prev();

        //remove active class from the current and add it to the next selector.
        current.removeClass("active");
        previous.addClass("active");

        ajaxCall({
            url: `api/get/Users.php?pageNo=${pageNo-1}`,
            type: "GET", 
            dataType: "json",     
        }, "paginate");
    }
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
        //set page number variable 
        pageNo = data.pageNo;
        totalPages = data.totalPages;
        //build tables
        buildTable(data);
        buildPagination(data);
    }
}

function handlePaginateResponse(data, textStatus, jqXHR) {    
    if(data.status != 200) {
        //TODO Error messages
    } else {
        //set page number variable 
        pageNo = data.pageNo;
        totalPages = data.totalPages;
        reBuildTable(data);
    }
}

/*
* commiter functions
*/

function buildTable(payload) {
    $("#users-table").append('<tbody>')
    payload.data.forEach(function(user) {
        $("#users-table").append(`<tr><td> ${user.firstName} ${user.lastName} </td> <td> ${user.group} </td></tr>`)
    });   
}

function buildPagination(payload) {
    //previous
    $(".pagination").append(`<li class="page-item" id="previous"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>`);
    $(".pagination").append(`<li class="page-item active" id="page-0" data-page="0"><a class="page-link" href="javascript:void(0)" >1</a></li>`);
    for(var i = 1; i < payload.totalPages; i++) {        
        $(".pagination").append(`<li class="page-item" id="page-${i}" data-page="${i}"><a class="page-link" href="javascript:void(0)" >${i+1}</a></li>`);
    }
    $(".pagination").append(`<li class="page-item" id="next"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>`);
    addEventsToPagination();
}

function reBuildTable(payload) {
    $("#users-table tbody").remove();
    
    $("#users-table").append('<tbody>')
    payload.data.forEach(function(user) {
        $("#users-table").append(`<tr><td> ${user.firstName} ${user.lastName} </td> <td> ${user.group} </td></tr>`)
    });
}

/**
 * Util functions
 */

function addEventsToPagination() {
    //hide previous button
    $("#previous").hide();
    $("#next").on("click", handleNextEvent);
    $("#previous").on("click", handlePreviousEvent);
}
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

var objMethods = {
    "login": {
        handleAction: handleLogInResponse        
    },
    "logout": {
        handleAction: handleLogOutResponse
    },
    "users": {
        handleAction: handleUsersResponse
    },
    "paginate": {
        handleAction: handlePaginateResponse
    }
}