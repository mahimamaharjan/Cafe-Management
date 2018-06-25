$(function() {
    console.log('LOGIN DOM is ready');

    var isUserLogged = checkUserLogin();
    console.log(isUserLogged);

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

    $('#login').click(function() {
        var email = $('#email_address').val();
        var password = $('#password').val();
        localStorage.setItem('userEmail', email);
        localStorage.setItem('userPassword', password);

        if (email === 'admin' && password === 'admin') {
            setTimeout(function(e) {
                var currentPath = window.location.pathname;
                var newPath = currentPath.replace(
                    'login.php',
                    'master_food_beverage.php',
                );

                window.location.replace(newPath);
            });
        }else {
            setTimeout(function(e) {
                var currentPath = window.location.pathname;
                var newPath = currentPath.replace(
                    'login.php',
                    '../index.php',
                );

                window.location.replace(newPath);
            });
        }
    });

    function checkUserLogin() {
        return (
            localStorage.hasOwnProperty('userEmail') &&
            localStorage.hasOwnProperty('userPassword')
        );
    }
});
