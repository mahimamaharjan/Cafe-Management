var dict = new Map();

var isValidStudentStaffId = false;
var isValidEmail = false;
var isValidCard = false;
var isValidPassword = false;
var isValidRepeatPassword = false;
var isValidAll = false;

$(function() {
    console.log('DOM is ready');

    var isUserLogged = checkUserLogin();

    if (isUserLogged) {
        $('.login a').remove();
        $('.register').remove();

        var logOut = $('<a>Logout</a>').addClass('logout');
        $('.login').append(logOut);

        $(logOut).click(function(e) {
            localStorage.removeItem('userEmail');
            localStorage.removeItem('userPassword');
            var menuEl = $('.mainmenu');
            var login = $(
                '<li class="login"><a href="pages/login.php">Log in</a>\n</li>',
            );
            var register = $(
                '<li class="register"><a href="pages/registration.php">Register</a></li>',
            );
            $('.login').remove();
            menuEl.append(login);
            menuEl.append(register);
        });
    }

    $('.studentStaffId').focusout(function() {
        isValidStudentStaffId = validateStudentStaffId($(this).val());
        console.log(validateStudentStaffId($(this).val()), 'dd', $(this).val());
        $(this)
            .closest('.right')
            .children('.errorMessage')
            .toggleClass('isInvalid', !isValidStudentStaffId);
        validateAll();
    });

    $('.emailAddress').focusout(function() {
        isValidEmail = ValidateEmail($(this).val());
        $(this)
            .closest('.right')
            .children('.errorMessage')
            .toggleClass('isInvalid', !isValidEmail);
        validateAll();
    });

    $('.creditCard').focusout(function() {
        isValidCard = validateCreditCard($(this).val());
        $(this)
            .closest('.right')
            .children('.errorMessage')
            .toggleClass('isInvalid', !isValidCard);
        validateAll();
    });

    $('.password').focusout(function() {
        isValidPassword = validatePassword($(this).val());
        $(this)
            .closest('.right')
            .children('.errorMessage')
            .toggleClass('isInvalid', !isValidPassword);
        validateAll();
    });

    $('.passwordConfirm').focusout(function() {
        isValidRepeatPassword = $('.password').val() === $(this).val();
        $(this)
            .closest('.right')
            .children('.errorMessage')
            .toggleClass('isInvalid', !isValidRepeatPassword);
        validateAll();
    });

    function checkUserLogin() {
        return (
            localStorage.hasOwnProperty('userEmail') &&
            localStorage.hasOwnProperty('userPassword')
        );
    }

    var specialChars = ['~', '!', '#', '$'];

    function validateStudentStaffId(studentId) {
        return !(studentId.length > 0 && studentId.length > 6);
    }

    function ValidateEmail(email) {
        // Taken from https://www.w3resource.com/javascript/form/email-validation.php
        return !(
            email.length > 0 &&
            !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
        );
    }

    function validateCreditCard(creditCardId) {
        return !(creditCardId.length > 0 && creditCardId.length !== 12);
    }

    function validatePassword(password) {
        var isValidLength =
            password.length > 0 && password.length > 5 && password.length < 13;
        var passArray = password.split('');
        var containLowerAndUpper = findLowerOrUpper(passArray);
        var containSpecial =
            passArray
                .map(function(char) {
                    return specialChars.indexOf(char) !== -1;
                })
                .indexOf(true) !== -1;

        var containNumber =
            passArray
                .map(function(char) {
                    return isNaN(char);
                })
                .indexOf(false) !== -1;
        return (
            isValidLength &&
            containLowerAndUpper &&
            containNumber &&
            containSpecial
        );
    }

    function findLowerOrUpper(password) {
        var validLower =
            password
                .map(function(character) {
                    return (
                        isNaN(character) &&
                        specialChars.indexOf(character) < 0 &&
                        character === character.toLowerCase()
                    );
                })
                .indexOf(true) !== -1;

        var validUpper =
            password
                .map(function(character, index) {
                    return (
                        isNaN(character) &&
                        specialChars.indexOf(character) < 0 &&
                        character === character.toUpperCase()
                    );
                })
                .indexOf(true) !== -1;
        return validLower && validUpper;
    }

    function validateAll() {
        isValidAll =
            isValidStudentStaffId &&
            isValidEmail &&
            isValidCard &&
            isValidPassword &&
            isValidRepeatPassword;

        $('.registerBtn').toggleClass('disabled', !isValidAll);
    }

    /* End of Registratin */
});
