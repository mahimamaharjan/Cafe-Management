$(function() {
    /** Start for Menu **/

    console.log('DOM loaded');
    var isUserLogged = checkUserLogin();

    if(isUserLogged){
        $('.login a').remove();
        $('.register').remove();

        var logOut = $('<a>Logout</a>').addClass('logout')
        $('.login').append(logOut)
        $(logOut).click(function (e) {
            localStorage.removeItem('userEmail');
            localStorage.removeItem('userPassword');
            var menuEl = $('.mainmenu');
            var login = $('<li class="login"><a href="pages/login.php">Log in</a>\n</li>')
            var register = $('<li class="register"><a href="pages/registration.php">Register</a></li>')
            $('.login').remove();
            menuEl.append(login)
            menuEl.append(register)

        })

    }


    var menuItems = [
        { id: 'foodItems', label: 'Food' },
        { id: 'drinksItem', label: 'Drinks' },
        { id: 'dessertItem', label: 'Dessert' },
    ];

    var dishes = [
        {
            id: 'foodItems',
            title: 'Available Food Items',
            dishitems: [
                {
                    id: 'justMain',
                    label: 'Just Mains',
                    price: '$25.90 (per person)',
                    descriptions:
                        'Chef’s selection of curries served with mixed naans, rice and condiments',
                },
                {
                    id: 'vegetarianDelights',
                    label: 'Vegetarian Delights',
                    price: '$27.90 (per person)',
                    descriptions: [
                        { id: 'Entrees', label: 'Samosa and Pakora' },
                        {
                            id: 'Mains',
                            label:
                                'Chef’s selection of vegetarian curries served with mixed naans, rice and condiments',
                        },
                    ],
                },
                {
                    id: 'rajaBanquet ',
                    label: 'Raja Banquet ',
                    price: '$30.90 (per person)',
                    descriptions: [
                        {
                            id: 'Entrees',
                            label:
                                'Pakora, Bombay Fried Prawns and a choice of Seekh kebab or Lamb Cutlets',
                        },
                        {
                            id: 'Mains',
                            label:
                                'Chef’s selection of curries served with mixed naans, rice and condiments',
                        },
                    ],
                },
                {
                    id: 'suriyaBanquet ',
                    label: 'Suriya Banquet',
                    price: '$34.90 (per person)',
                    descriptions: [
                        {
                            id: 'Entrees',
                            label:
                                'Samosa, Bombay Fried Prawns, Chicken Tikka and a choice of Seekh kebab or Lamb Cutlets',
                        },
                        {
                            id: 'Mains',
                            label:
                                'Chef’s selection of seafood, vegetable, chicken, lamb and beef curries, mixed naans, rice and condiments',
                        },
                        {
                            id: 'Desserts',
                            label: 'Tea or coffee or desserts',
                        },
                    ],
                },
            ],
        },
        {
            id: 'drinksItem',
            title: 'Available Drinks Items',
            dishitems: [
                {
                    id: 'Dry Ginger Ale ',
                    label: 'Dry Ginger Ale',
                    price: '$4.7',
                    descriptions: 'Dry Ginger Ale',
                },
                {
                    id: 'Lemonade',
                    label: 'Lemonade',
                    price: '$4.7',
                    descriptions: 'Lemonade',
                },
                {
                    id: 'Schweppes Agrum Blood Orange Blend',
                    label: 'Schweppes Agrum Blood Orange Blend',
                    price: '$6.90',
                    descriptions: 'Schweppes Agrum Blood Orange Blend',
                },
                {
                    id: 'Lemon, Lime & Bitters',
                    label: 'Lemon, Lime & Bitters',
                    price: ' $10.90',
                    descriptions: 'Lemon, Lime & Bitters',
                },
                {
                    id: 'Voss Sparkling Water, 800ml',
                    label: 'Voss Sparkling Water, 800ml',
                    price: '$11.90',
                    descriptions: 'Voss Sparkling Water, 800ml',
                },
            ],
        },
        {
            id: 'dessertItem',
            title: 'Available Dessert Items',
            dishitems: [
                {
                    id: 'Kulfi',
                    label: 'Kulfi',
                    price: '$18.90',
                    descriptions:
                        'India’s traditional ice cream, sticky and sweet and totally delicious',
                },
                {
                    id: 'Gulab Jamun',
                    label: 'Gulab Jamun',
                    price: '$5.90',
                    descriptions:
                        'Milk dumplings deep fried and drenched in a rose water syrup',
                },
                {
                    id: 'Gulab Jamun with Ice Cream',
                    label: 'Gulab Jamun with Ice Cream',
                    price: '$18.90',
                    descriptions:
                        'Gulab Jamun served with your choice of vanilla or chocolate ice cream',
                },
                {
                    id: 'Balti Chicken',
                    label: 'Calcutta Chicken',
                    price: ' $18.90',
                    descriptions:
                        'Traditional Balti style chicken sautéed with onion, capsicum and tomatoes',
                },
                {
                    id: 'Just Ice Cream ',
                    label: 'Just Ice Cream',
                    price: '$11.90',
                    descriptions: 'Vanilla or chocolate with choice of topping',
                },
            ],
        },
    ];

    $.each(menuItems, function(index, value) {
        console.log(index, value, localStorage);
        var middle = $('.middle');
        var item = $('<div></div>')
            .text(value.label)
            .addClass('menuNav')
            .attr('id', value.id)
            .click(function(d) {
                var menuId = d.target.id;
                $('.menuNav').removeClass('active');
                $(this).toggleClass('active');
                var dishSelect = $('.dishid-' + menuId);

                $('.dishContainer').removeClass('visible');

                dishSelect.addClass('visible');
            });

        middle.append(item);
    });

    var bottomContainer = $('.bottom');

    $.each(dishes, function(index, dishItem) {
        console.log(dishItem, 'bottom', index);

        var dishContainer = $('<div></div>').addClass(
            'dishContainer dishid-' + dishItem.id,
        );

        if (index === 0) {
            dishContainer.addClass('visible');
        }

        bottomContainer.append(dishContainer);
        var menu = $('<div></div>').addClass('menu');
        var title = $('<h1></h1>').text(dishItem.title);

        menu.append(title);
        dishContainer.append(menu);
        $.each(dishItem.dishitems, function(index, dishItem) {
            generateBottom(dishContainer, dishItem);
        });
    });

    function generateBottom(bottomContainer, item) {
        var row = $('<div></div>').addClass('row');
        var rowTitle = $('<div></div>')
            .addClass('title')
            .text(item.label + ' ' + item.price);

        row.append(rowTitle);

        var content = $('<div></div>').addClass('content');
        var imageEl = $('<div></div>').addClass('image');
        var img = $('<img></img>')
            .addClass('image')
            .attr('src', '../img/menu/banquet.jpg');

        imageEl.append(img);
        content.append(imageEl);
        var descriptionEl = $('<div></div>').addClass('description');

        if (item && Array.isArray(item.descriptions)) {
            $.each(item.descriptions, function(index, desc) {
                var child = $('<div></div>')
                    .addClass('descItems')
                    .text(desc.label);
                descriptionEl.append(child);
            });
        } else {
            var singleDescription = $('<div></div>')
                .addClass('descItems')
                .text(item.descriptions);
            descriptionEl.append(singleDescription);
        }

        content.append(descriptionEl);

        var isUserLoggedIn = checkUserLogin();
        if (isUserLoggedIn) {
            var qtyEl = $('<div></div>').addClass('qty');

            var label = $('<div></div>')
                .addClass('label')
                .text('Quantity');
            var inputQty = $('<input type="number">');

            qtyEl.append(label);
            qtyEl.append(inputQty);
            content.append(qtyEl);

            var commentEl = $('<div></div>').addClass('comment');

            var textAreaEl = $('<textarea></textarea>').addClass('commentdesc');

            commentEl.append(textAreaEl);
            content.append(commentEl);

            var addToBasket = $('<div></div>')
                .addClass('addtobasket')
                .text('Order');

            content.append(addToBasket);
        }

        row.append(content);

        bottomContainer.append(row);
    }

    function checkUserLogin() {
        return (
            localStorage.hasOwnProperty('userEmail') &&
            localStorage.hasOwnProperty('userPassword')
        );
    }

    /* End of Menu */
});
