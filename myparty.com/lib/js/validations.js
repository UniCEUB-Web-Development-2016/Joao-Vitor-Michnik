var tfirstname;
var tlastname;
var tdate;
var temail;
var tlogin;
var tpass;
var tconfirmpass;
var password;
function validateFirstName(firstname){

    var nameRegEx = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/;
    if (!nameRegEx.test(firstname)) {
        document.getElementById("validateFirstName").innerHTML = '<div id="noticeName" class="col-md-10 alert alert-danger validation">First name is invalid.</div>';
        document.getElementById("divFirstName").className = "form-group col-md-4 has-error has-feedback marginbottom10";
        document.getElementById("iconFirstName").className = "fa fa-times";
        var invalid = true;
    }else{
        var invalid = false;
    }
    if (firstname == null || firstname == "") {
        document.getElementById("validateFirstName").innerHTML = '<div id="noticeName" class="col-md-10 alert alert-danger validation">First name is empty.</div>';
        empty = true;
    }else{
        empty = false;
    }
    if(!empty && !invalid){
        document.getElementById("validateFirstName").innerHTML = "";
        document.getElementById("divFirstName").className = "form-group col-md-4 has-success has-feedback marginbottom10";
        document.getElementById("iconFirstName").className = "fa fa-check";
        tfirstname = true;
    }else{
        tfirstname = false;
    }
};
function validateLastName(lastname){

    var nameRegEx = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/;
    if (!nameRegEx.test(lastname)) {
        document.getElementById("validateLastName").innerHTML = '<div id="noticeLastName" class="col-md-10 alert alert-danger validation">Last name is invalid.</div>';
        document.getElementById("divLastName").className = "form-group col-md-6 has-error has-feedback marginbottom10";
        document.getElementById("iconLastName").className = "fa fa-times";
        var invalidLast = true;
    }else{
        var invalidLast = false;
    }
    if (lastname == null || lastname == "") {
        document.getElementById("validateLastName").innerHTML = '<div id="noticeLastName" class="col-md-10 alert alert-danger validation">Last name is empty.</div>';
        var emptyLast = true;
    }else{
        var emptyLast = false;
    }
    if(!emptyLast && !invalidLast){
        document.getElementById("validateLastName").innerHTML = "";
        document.getElementById("divLastName").className = "form-group col-md-6 has-success has-feedback marginbottom10";
        document.getElementById("iconLastName").className = "fa fa-check";
        tlastname = true;
    }else{
        tlastname = false;
    }
};
function validateDate(date){

    if (date == null || date == "") {
        document.getElementById("validateDate").innerHTML = '<div id="noticeName" class="col-md-10 alert alert-danger validation">Date is invalid.</div>';
        document.getElementById("divDate").className = "form-group col-md-5 has-error has-feedback marginbottom10";
        document.getElementById("iconDate").className = "fa fa-times";
        tdate = false;
    }else{
        document.getElementById("validateDate").innerHTML = "";
        document.getElementById("divDate").className = "form-group col-md-5 has-success has-feedback marginbottom10";
        document.getElementById("iconDate").className = "fa fa-check";
        tdate = true;
    }
};
function validateEmail(value){

    var email = document.getElementById('email');
    //Regular Expression for checking email
    var emailRegEx = /[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/;
    if (!emailRegEx.test(email.value)) {
        document.getElementById("validateEmail").innerHTML = '<div id="noticeEmail" class="col-md-10 alert alert-danger validation">Invalid email.</div>';
        document.getElementById("divEmail").className = "form-group col-md-10 has-error has-feedback marginbottom10";
        document.getElementById("iconEmail").className = "fa fa-times";
        var invalid = true;
    }else{
        var invalid = false;
    }
    if (value == null || value == "") {
        document.getElementById("validateEmail").innerHTML = '<div id="noticeEmail" class="col-md-10 alert alert-danger validation">Email is empty.</div>';
        var empty = true;
    }else{
        var empty = false;
    }
    if(!empty && !invalid){
        document.getElementById("validateEmail").innerHTML = "";
        document.getElementById("divEmail").className = "form-group col-md-10 has-success has-feedback marginbottom10";
        document.getElementById("iconEmail").className = "fa fa-check";
        temail = true;
    }else{
        temail = false;
    }
};
function validateLogin(login){

    var nameRegEx = /^[a-zA-Z0-9_-]{3,15}$/;
    if (!nameRegEx.test(login)) {
        document.getElementById("validateLogin").innerHTML = '<div id="noticeLogin" class="col-md-10 alert alert-danger validation">Login is invalid, please only use 3-15 characters, A-Z, 0-9, _, - </div>';
        document.getElementById("divLogin").className = "form-group col-md-5 has-error has-feedback marginbottom10";
        document.getElementById("iconLogin").className = "fa fa-times";
        var invalid = true;
    }else{
        var invalid = false;
    }
    if (login == null || login == "") {
        document.getElementById("validateLogin").innerHTML = '<div id="noticeLogin" class="col-md-10 alert alert-danger validation">Login is empty.</div>';
        var empty = true;
    }else{
        var empty = false;
    }
    if(!empty && !invalid){
        document.getElementById("validateLogin").innerHTML = "";
        document.getElementById("divLogin").className = "form-group col-md-5 has-success has-feedback marginbottom10";
        document.getElementById("iconLogin").className = "fa fa-check";
        tlogin = true;
    }else{
        tlogin = false;
    }
};
function validatePassword(pass){
    var nameRegEx = /^(.{6,15})$/;
    if (!nameRegEx.test(pass)) {
        document.getElementById("validatePass").innerHTML = '<div id="noticePass" class="col-md-10 alert alert-danger validation">Password is invalid , please use 6-15 characters. </div>';
        document.getElementById("divPass").className = "form-group col-md-5 has-error has-feedback marginbottom10";
        document.getElementById("iconPass").className = "fa fa-times";
        var invalid = true;
    }else{
        var invalid = false;
    }
    if (pass == null || pass == "") {
        document.getElementById("validatePass").innerHTML = '<div id="noticePass" class="col-md-10 alert alert-danger validation">Login is empty.</div>';
        var empty = true;
    }else{
        var empty = false;
    }
    if(!empty && !invalid) {
        document.getElementById("validatePass").innerHTML = "";
        document.getElementById("divPass").className = "form-group col-md-5 has-success has-feedback marginbottom10";
        document.getElementById("iconPass").className = "fa fa-check";
        tpass = true;
        password = true;
    }else{
        tpass = false;
        password = false;
    }
};
function validateConfirmPass(){
    var getPassword = document.getElementById('first_password').value;
    var getConfirmPassword = document.getElementById('confirm_password').value;
    if (!password) {
        document.getElementById("validateConfirmPass").innerHTML = '<div id="noticeConfirmPass" class="col-md-10 alert alert-danger validation">Please, enter a valid password to confirm.</div>';
        document.getElementById("divConfirmPass").className = "form-group col-md-5 has-error has-feedback marginbottom10";
        document.getElementById("iconConfirmPass").className = "fa fa-times";
        var invalidPass = true;
    }else{
        var invalidPass = false;
    }
    if(!invalidPass) {
        if (getPassword == getConfirmPassword) {
            document.getElementById("validateConfirmPass").innerHTML = "";
            document.getElementById("divConfirmPass").className = "form-group col-md-5 has-success has-feedback marginbottom10";
            document.getElementById("iconConfirmPass").className = "fa fa-check";
            tconfirmpass = true;
        }
        else {
            document.getElementById("validateConfirmPass").innerHTML = '<div id="noticeConfirmPass" class="col-md-10 alert alert-danger validation">The fields arent equals.</div>';
            document.getElementById("divConfirmPass").className = "form-group col-md-6 has-error has-feedback marginbottom10";
            document.getElementById("iconConfirmPass").className = "fa fa-times";
            tconfirmpass = false;
        }
    }
};
function enablesubmit(){
    if(tfirstname && tlastname && tdate && temail && tlogin && tpass && tconfirmpass){
        document.getElementById('modalSend').disabled = false;
    }else{
        document.getElementById('modalSend').disabled = true;
    }
};