const colors = {
  color_primary: '#1D6BEC',
  color_secondary: '#C3C3C3',
  color_success: '#24D548',
  color_warning: '#FFB138',
  color_danger: '#E6152C',
  color_info: '#30D696',
  color_power: '#8B34C3',
  color_light: '#fafafa',
  color_dark: '#303030',
}

const components = {
  notification: {
    selector: 'notification',
    ...colors,

    classAnimateIn: 'hc--notification-animateIn',
    classAnimateOut: 'hc--notification-animateOut',
    classDef: 'hc--notification',

    icon: '',
    title: '',
    description: '',
    footer: '',

    textColor: colors.light,
    backgroundColor: colors.primary,

    timeoutToRemove: 300,
    timeoutToLeaveScreen: 11000,
    leaveOnClick: true,
    redirectOnClick: false,
    redirectTo: '#',

    onclick: null,
    onmouseenter: null,
    onmouseleave: null,
  },
  swiftBackground: {
    selector: 'swift_background',
    ...colors,

    color: null,
    classDef: 'hc--swiftBackground',

    onclick: null,
  }
}

let componentsTimeout = {
  notification: null
}

function hget_component(options = {}, resetComponent = false) {
  // Getting or creating component in DOM
  const selector = `[component="${options.selector}"]`;
  let component = document.querySelector(selector);

  if (!component) {
    component = document.createElement('div');
    component.setAttribute('component', options.selector);
    document.querySelector('body').appendChild(component);
    component = document.querySelector(selector);
  }

  if (resetComponent) {
    component.innerHTML = '';
    component.style.display = 'none';
  }

  return component;
}

$notificate = function(custom_options = {}) {

  // Setting the options
  const options = {
    ...components.notification,
    ...custom_options,
  };

  component = hget_component(options, true);

  // Setting content
  content = {
    icon: options.icon,
    title: options.title,
    description: options.description,
    footer: options.footer,
  }

  // Icon settings
  let icon = document.createElement('span');
  if (content.icon) icon.className = `mdi mdi-${content.icon}`;
  icon.style = `
    font-size: 2.3rem;
    margin-right: .5rem;
    width: 38px;
    text-align: center;
  `;

  // Title settings
  let title = document.createElement('div');
  if (content.title) title.innerHTML = content.title;
  title.style = `
    font-size: 1.35rem;
  `;

  // Description settings
  let description = document.createElement('div');
  if (content.description) description.innerHTML = content.description;
  description.style = `
    font-size: .9rem;
  `;

  // Footer settings
  let footer = document.createElement('div');
  if (content.footer) footer.innerHTML = content.footer;
  footer.style = `
    font-size: .85rem;
    text-align: right;
  `;

  // Title, Description and Footer Container
  let con0 = document.createElement('div');
  con0.appendChild(title);
  con0.appendChild(description);
  con0.appendChild(footer);
  con0.style = `
    width: 326px;
    margin: 0 auto;
  `;

  component.appendChild(icon);
  component.appendChild(con0);

  // Colors
  if (options.backgroundColor) {
    component.style.backgroundColor = options.backgroundColor
  } else {
    component.style.backgroundColor = colors.color_primary
  }

  if (options.textColor) {
    component.style.color = options.textColor
  } else {
    component.style.color = colors.color_light
  }

  // Adding events
  if (options.onclick) {
    component.addEventListener('click', function() {
      options.onclick()
    });
  }

  if (options.onmouseenter) {
    component.addEventListener('mouseenter', function() {
      options.onmouseenter()
    });
  }

  if (options.onmouseleave) {
    component.addEventListener('mouseleave', function() {
      options.onmouseleave()
    });
  }

  if (options.leaveOnClick) {
    component.addEventListener('click', function() {
      clearTimeout(componentsTimeout.notification)
      $notificateClose();
    });
  }

  if (options.redirectOnClick) {
    component.addEventListener('click', function() {
      window.location.href = options.redirectTo;
    });
  }

  // Classes
  component.classList.contains(options.classAnimateIn)
      component.classList.remove(options.classAnimateIn);
  component.classList.contains(options.classAnimateOut)
      component.classList.remove(options.classAnimateOut);

  component.classList.add(options.classDef);
  component.classList.add(options.classAnimateIn);

  // Finally displaying component
  component.style.display = '';

  componentsTimeout.notification = setTimeout(() => {
    $notificateClose();
  }, options.timeoutToLeaveScreen);
  
  return component;
}

$notificateClose = function() {

  let component = hget_component(components.notification);

  // Classes
  component.classList.contains(components.notification.classAnimateIn)
      component.classList.remove(components.notification.classAnimateIn);
  component.classList.contains(components.notification.classAnimateOut)
      component.classList.remove(components.notification.classAnimateOut);

  component.classList.add(components.notification.classAnimateOut);

  setTimeout(() => {
    component.style.display = 'none';
  }, components.notification.timeoutToRemove);

  return component;
}

$swiftBackground = function(custom_options = {}) {
  // Setting the options
  const options = {
    ...components.swiftBackground,
    ...custom_options,
  };

  component = hget_component(options, true);

  // Classes
  component.classList.add(options.classDef);

  // Colors
  if (options.color) {
    component.style.backgroundColor = options.color
    component.style.opacity = '.55';
  }

  // Adding events
  if (options.onclick) {
    component.addEventListener('click', function() {
      options.onclick()
    });
  }

  component.style.display = '';

  return component;
}

$closeSwiftBackground = function() {
  let component = hget_component(components.swiftBackground);
  component.style.display = 'none';
  return component;
}