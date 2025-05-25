document.querySelectorAll('.dropdown-toggle').forEach(dropDownFunc);

function dropDownFunc(dropDown) {
    console.log(dropDown.classList.contains('click-dropdown'));

    if (dropDown.classList.contains('click-dropdown') === true) {
        dropDown.addEventListener('click', function (e) {
            e.preventDefault();

            if (this.nextElementSibling.classList.contains('dropdown-active') === true) {
                this.parentElement.classList.remove('dropdown-open');
                this.nextElementSibling.classList.remove('dropdown-active');

            } else {
                closeDropdown();

                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
        });
    }

    if (dropDown.classList.contains('hover-dropdown') === true) {

        dropDown.onmouseover = dropDown.onmouseout = dropdownHover;

        function dropdownHover(e) {
            if (e.type === 'mouseover') {
                closeDropdown();
                this.parentElement.classList.add('dropdown-open');
                this.nextElementSibling.classList.add('dropdown-active');
            }
            if (e.type === 'mouseout') {
                e.target.nextElementSibling.onmouseleave = closeDropdown;
            }
        }
    }

}

window.addEventListener('click', function (e) {
    if (e.target.closest('.dropdown-container') === null) {
        closeDropdown();
    }

});

function closeDropdown() {
    document.querySelectorAll('.dropdown-container').forEach(function (container) {
        container.classList.remove('dropdown-open')
    });

    document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
        menu.classList.remove('dropdown-active');
    });
}

document.querySelectorAll('.dropdown-menu').forEach(function (dropDownList) {
    dropDownList.onmouseleave = closeDropdown;
});
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dropdown-container').forEach(function (price) {
        price.text((i, text) => {
            const [price, currency] = text.split(' ');
            return `${(+price).toLocaleString()} ${currency}`;
        });
    })
});


document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const item = button.parentElement;
        item.classList.toggle('active');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Обработчик клика по иконке "Избранное"
    document.addEventListener('click', (e) => {
        const favIcon = e.target.closest('.favorite');
        if (!favIcon) return;

        e.preventDefault();
        e.stopPropagation();

        const productId = favIcon.dataset.productId;
        const isActive = favIcon.classList.contains('active');

        const url = isActive
            ? '/pages/remove_from_favorites.php'
            : '/pages/add_to_favorites.php';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}`
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    favIcon.classList.toggle('active');
                } else {
                    console.error('Ошибка сервера:', data.message);
                }
            })
            .catch(err => {
                console.error('Ошибка при работе с избранным:', err);
            });
    });
});

