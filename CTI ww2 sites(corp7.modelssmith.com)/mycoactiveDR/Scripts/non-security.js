// Non Security is essentually a security hack!
// This script when included on a page will redirect the user if not authenticed

// Single place to edit all of this non secure stuff. 

// Some History: This site started as a tempory quick hack recovery site because the main site was down.
// It had to be up and runing in a few days. The security wasn't the main concern.

// I placed everything with Authentication in this central location hoping to save someone (me) time later.

// This script assumes that all files are one folder off the root /English /Spanish /Turkish an no deeper.
// This script also assumes that each language files are named exactly the same thing in each language with different content.

// if you have time to rewrite the athunentication, do it.

var isAuthenticated = localStorage.getItem("authenticed")
if (isAuthenticated === "true") {
    // do nothing
} else {
    window.location = "../index.html";
}

// On Document Ready
$(function () {

    var userType = localStorage.getItem("UserType");
    if (userType === "Faculty") {
        $('#facultyViewAsDropDown').show();
    } else {
        $('#facultyViewAsDropDown').hide();
    }

    var userName = localStorage.getItem("UserName");
    $('#userName').text(userName);

    //wire up the logout button click if it exists on the page.
    $('#logout').click(logoutClick);

});

function logoutClick() {
    localStorage.setItem("UserType", "");
    localStorage.setItem("UserName", "");
    localStorage.setItem("authenticed", "");
    window.location = "../index.html";
}

function showFacultyView() {
    localStorage.setItem("LastStudentPage", "manual.html")
    var lastFacultyPage = localStorage.getItem("LastFacultyPage");
    if (lastFacultyPage) {
        window.location = lastFacultyPage;
    } else {
        window.location = "facultyExams.html";
    }
}

function showStudentView() {
    localStorage.setItem("LastFacultyPage", "facultyCPLS.html")
    var LastStudentPage = localStorage.getItem("LastStudentPage");
    if (LastStudentPage) {
        window.location = LastStudentPage;
    } else {
        window.location = "manual.html";
    }
}
