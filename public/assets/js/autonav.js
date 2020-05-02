/* 
 * Author: Deyvid Holz Trames
 * Description: A responsive navigation bar creator with some features.
 * Version: 1.0
 * Github: https://www.github.com/deyvidholz
 * 
 * Thanks for using :)
*/

let url = window.location.pathname;
let route = url.substring(url.lastIndexOf('/')+1);

const options = {
    main: {
        title: 'Harpia',
        image: {
            src: null,
            alt: 'Navbar Logo',
            height: '60px',
            maxWidth: null,
            fnClick: function() { window.location.href = './' }
        },
    },
    menu: {
        closeMobileMenuOnClick: true,
        activeClass: 'autonavActive',
        fnFinish: function() { },
        links: [{
            iconElement: null,
            iconSrc: null,
            iconClass: null,
            iconStyle: null,
            text: 'Home',
            name: '',
            href: './',
            queryString: null,
            fnClick: function() { }
        }, {
            iconElement: null,
            iconSrc: null,
            iconClass: null,
            iconStyle: null,
            text: 'Login',
            name: 'login',
            href: './login',
            queryString: null,
            fnClick: function() { }
        }, {
            iconElement: null,
            iconSrc: null,
            iconClass: null,
            iconStyle: null,
            text: 'Register',
            name: 'register',
            href: './register',
            queryString: null,
            fnClick: function() {}
        }]
    },
    config: {
        insertMarginTop: true,
        marginTopIncrement: '26px',
        align: 'default',
        backgroundColor: '#F2F2F2',
        textColor: '#303030',
        textUppercase: true,
        textPaddingY: '0',
        textPaddingX: '18px',
        removeLastMenuPadding: true,
        removeLastMenuPaddingFrom: 'right',
        textBold: true,
        textItalic: false,
        showMenuHamburgerSize: 768,
        menuHamburger: {
            element: 'img',
            src: './assets/img/menu.png',
            class: null,
            style: 'width: 30;',
            backgroundColor: '#F2F2F230',
            textColor: '#303030',
            fnClick: function() {
                autonavShowMobileMenu(); // Show the menu for mobile devices
                // Write your code below
            }
        },
        mobileMenu: {
            closeElement: 'img',
            closeSrc: './assets/img/close.png',
            closeElementClass: null,
            closeElementStyle: 'width: 30;',
            animationInClass: 'autonavMobileInRight',
            animationOutClass: 'autonavMobileOutRight',
            waitBeforeRemove: 0.52, // The menu will wait this time before disappear
            closeFnClick: function() {
                autonavCloseMobileMenu(); // Hide the menu for mobile devices
                // Write your code below
            }
        }
    }
};

function autonavInit() {
    // console.warn('AutonavJS initializing...');

    // Alignment
    let alignProp;
    switch(options.config.align) {
        case 'left':
            alignProp = 'flex-start';
            break;
        case 'center':
            alignProp = 'center';
            break;
        case 'right':
            alignProp = 'flex-end';
            break;
        case 'default':
            alignProp = 'space-between';
            break;
        default:
            alignProp = 'space-between';
            break;
    }

    // Creating elements -> Container
    let container = document.createElement('nav');
    container.style = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        padding: 13px 22px;
        display: flex;
        align-items: center;
        justify-content: ${alignProp};
        color: ${options.config.textColor};
        background-color: ${options.config.backgroundColor};
        box-shadow: 0px 2px 11px -2px rgba(0,0,0,0.75);
        z-index: 998;
    `;

    // -> Logo Image Container
    let logoContainer = document.createElement('div');
    logoContainer.style = `
        height: ${options.main.image.height};
        max-width: ${options.main.image.maxWidth};
        display: flex;
        align-items: center;
    `;
    logoContainer.style.cursor = 'pointer';
    logoContainer.onclick = options.main.image.fnClick;

    // -> Image
    let logoImage = options.main.image.src != null ? document.createElement('img') : null;

    if(logoImage) {
        logoImage.src = options.main.image.src
        logoImage.alt = options.main.image.alt
        logoImage.style = `
            height: ${options.main.image.height};
            max-width: ${options.main.image.maxWidth};
        `;
    }

    // -> Title
    let logoTitle = document.createElement('span');
    logoTitle.style.fontSize = '1.7em';
    logoTitle.innerHTML = options.main.title;

    // -> Menu Container
    let menuContainer = document.createElement('div');
    menuContainer.setAttribute('navmenu', '');

    // -> Menu Container (mobile devices)
    let menuContainerMobile = document.createElement('div');

    // -> Menu and Links
    var counter = 0;
    options.menu.links.forEach(link => {
        counter++;

        let currentLinkContainer = document.createElement('div');
        let currentLinkIcon = link.iconElement != null ? document.createElement(link.iconElement) : null;
        let currentLink = document.createElement('a');

        if (currentLinkIcon) {
            currentLinkIcon.className = link.iconClass != null ? link.iconClass : '';
            currentLinkIcon.style = link.iconStyle != null ? link.iconStyle : '';
            if (link.iconSrc) {
                currentLinkIcon.src = link.iconSrc;
            }
        }

        // --> Creating icon
        currentLink.innerHTML = link.text;
        if(currentLinkIcon) {
            currentLink.insertBefore(currentLinkIcon, currentLink.firstChild)
        }
        currentLink.href = link.queryString != null ? link.href + '?' + link.queryString : link.href;
        currentLink.style = `
            color: ${options.config.textColor};
            text-decoration: none;
        `;
        currentLink.style.textTransform = options.config.textUppercase ? 'uppercase' : null;
        currentLink.style.fontWeight = options.config.textBold ? 'bold' : null;
        currentLink.style.fontStyle = options.config.textItalic ? 'italic' : null;
        currentLink.onclick = link.fnClick;

        if (options.config.removeLastMenuPadding && (counter === options.menu.links.length)) {
            if (options.config.removeLastMenuPaddingFrom === 'top') {
                currentLink.style.paddingTop = `0`;
            } else {
                currentLink.style.paddingTop = `${options.config.textPaddingY}`;
            }
            if (options.config.removeLastMenuPaddingFrom === 'bottom') {
                currentLink.style.paddingBottom = `0`;
            } else {
                currentLink.style.paddingBottom = `${options.config.textPaddingY}`;
            }
            if (options.config.removeLastMenuPaddingFrom === 'left') {
                currentLink.style.paddingLeft = `0`;
            } else {
                currentLink.style.paddingLeft = `${options.config.textPaddingX}`;
            }
            if (options.config.removeLastMenuPaddingFrom === 'right') {
                currentLink.style.paddingRight = `0`;
            } else {
                currentLink.style.paddingRight = `${options.config.textPaddingX}`;
            }
        } else {
            currentLink.style.paddingTop = `${options.config.textPaddingY}`;
            currentLink.style.paddingBottom = `${options.config.textPaddingY}`;
            currentLink.style.paddingLeft = `${options.config.textPaddingX}`;
            currentLink.style.paddingRight = `${options.config.textPaddingX}`;
        }

        if (link.name === route) {
            currentLink.className += ' ' + options.menu.activeClass;
        }
        
        menuContainer.append(currentLink);

        let currentLinkMobile = currentLink.cloneNode(true);
        currentLinkMobile.style.padding = '4px 0';
        currentLinkMobile.style.margin = '0';
        currentLinkMobile.style.fontSize = '1.3em';

        currentLinkMobile.onclick = function() {
            link.fnClick();

            if(options.menu.closeMobileMenuOnClick) {
                autonavCloseMobileMenu();
            }
        };
        menuContainerMobile.append(currentLinkMobile);
    });

    if (options.menu.fnFinish) options.menu.fnFinish();

    // -> Creating mobile menu icon
    let mobileMenuIcon = document.createElement(options.config.menuHamburger.element);
    mobileMenuIcon.className = options.config.menuHamburger.class != null ? options.config.menuHamburger.class : null;
    mobileMenuIcon.src = options.config.menuHamburger.src != null ? options.config.menuHamburger.src : null;
    mobileMenuIcon.style = options.config.menuHamburger.style != null ? options.config.menuHamburger.style : null;
    mobileMenuIcon.style.cursor = 'pointer';
    mobileMenuIcon.style.display = 'none';
    mobileMenuIcon.onclick = options.config.menuHamburger.fnClick;
    mobileMenuIcon.setAttribute('nav-mobile-menu-icon', '');

    if (logoImage) {
        logoContainer.append(logoImage);
    } else {
        logoContainer.append(logoTitle);
    }
    
    container.appendChild(logoContainer);
    container.appendChild(menuContainer);
    container.append(mobileMenuIcon)

    // -> Mobile menu
    logoContainerMobile = logoContainer.cloneNode(true);
    logoContainerMobile.style = 'margin-top: 7.5%; margin-bottom: 26px;';
    menuContainerMobile.insertBefore(logoContainerMobile, menuContainerMobile.firstChild)

    menuContainerMobile.style = `
        display: flex;
        flex-direction: column;
        justify-content: center;
    `;

    let mobileMenu = document.createElement('div');
    mobileMenu.setAttribute('mobile-menu-icon', '');
    mobileMenu.append(menuContainerMobile);
    mobileMenu.style = `
        position: fixed;
        z-index: 998;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        background-color: ${options.config.menuHamburger.backgroundColor};
        color: ${options.config.menuHamburger.textColor};
        backdrop-filter: blur(10px);
    `;

    let mobileMenuClose = document.createElement(options.config.mobileMenu.closeElement);
    mobileMenuClose.className = options.config.mobileMenu.closeElementClass ? options.config.mobileMenu.closeElementClass : null;
    mobileMenuClose.src = options.config.mobileMenu.closeSrc ? options.config.mobileMenu.closeSrc : null;
    mobileMenuClose.style = options.config.mobileMenu.closeElementStyle ? options.config.mobileMenu.closeElementStyle : null;
    mobileMenuClose.style.position = 'absolute';
    mobileMenuClose.style.top = '15px';
    mobileMenuClose.style.right = '15px';
    mobileMenuClose.style.cursor = 'pointer';
    mobileMenuClose.onclick = options.config.mobileMenu.closeFnClick;

    mobileMenu.appendChild(mobileMenuClose)
    container.appendChild(mobileMenu);
    if (document.querySelector('[navbar]')) document.querySelector('[navbar]').append(container);

    // console.warn('AutonavJS loaded.');
}

function autonavShowMobileMenu() {
    if (document.querySelector('[mobile-menu-icon]')) {
        document.querySelector('[mobile-menu-icon]').className = options.config.mobileMenu.animationInClass ? options.config.mobileMenu.animationInClass : null;
        document.querySelector('[mobile-menu-icon]').style.display = '';
    }

}

function autonavCloseMobileMenu() {
    if (document.querySelector('[mobile-menu-icon]')) {
        if(options.config.mobileMenu.animationInClass) {
            document.querySelector('[mobile-menu-icon]').classList.remove(options.config.mobileMenu.animationInClass);
            if (options.config.mobileMenu.animationOutClass) {
                document.querySelector('[mobile-menu-icon]').className = options.config.mobileMenu.animationOutClass;
            }
        }
        let wait = 0;
        if (options.config.mobileMenu.waitBeforeRemove) {
            wait = options.config.mobileMenu.waitBeforeRemove * 1000;
        }
        setTimeout(function() {
            document.querySelector('[mobile-menu-icon]').style.display = 'none';
        }, wait);
    }
}

function autonavResponsive() {
    let w = document.documentElement.clientWidth;

    // Hide mobile menu
    document.querySelector('[mobile-menu-icon]') ? document.querySelector('[mobile-menu-icon]').style.display = 'none' : false;

    if (document.querySelector('[navmenu]')) {
      if (w <= options.config.showMenuHamburgerSize) {
          document.querySelector('[navmenu]').style.display = 'none';
          document.querySelector('[nav-mobile-menu-icon]').style.display = '';
      } else {
          document.querySelector('[nav-mobile-menu-icon]').style.display = 'none';
          document.querySelector('[navmenu]').style.display = '';
      }
    }
}

window.addEventListener('resize', function() {
    autonavResponsive();
});

window.addEventListener('load', function() {
    autonavResponsive();
});

document.addEventListener("DOMContentLoaded", function() { 
    if (options.config.insertMarginTop) {
      if (document.querySelector('[navmenu]')) {
        let marginTop = document.querySelector('[navbar] nav').clientHeight + 'px';
        
        let element = document.createElement('div');
        if (options.config.marginTopIncrement) {
            element.style.marginTop = `calc(${marginTop} + ${options.config.marginTopIncrement})`;
        } else {
            element.style.marginTop = marginTop;
        }
        document.querySelector('body').insertBefore(element, document.querySelector('[navbar]'));
      }
    }
});

autonavInit();