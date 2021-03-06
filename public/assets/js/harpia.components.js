const colors = {
  color_primary: '#1D6BEC',
  color_secondary: '#C3C3C3',
  color_success: '#37cc50',
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
  },
  dialog: {
    selector: 'dialog',
    ...colors,

    classAnimateIn: 'hc--dialog-animateIn',
    classAnimateOut: 'hc--dialog-animateOut',
    classDef: 'hc--dialog',
    classIconContainer: 'hc--dialog-icon',

    icon: 'close',
    title: '',
    description: '',
    footer: '',

    textColor: colors.dark,
    backgroundColor: colors.light,

    timeoutToRemove: 560,
  },
  window: {
    selector: 'window',
    ...colors,

    centerContent: false,

    classAnimateIn: 'hc--window-animateIn',
    classAnimateOut: 'hc--window-animateOut',
    classDef: 'hc--window',

    content: '',

    textColor: colors.dark,
    backgroundColor: colors.light,

    timeoutToRemove: 560,
  },
  loading: {
    selector: 'loading',
    ...colors,
    
    classAnimateIn: 'hc--loading-animateIn',
    classAnimateOut: 'hc--loading-animateOut',
    classDef: 'hc--loading',
    classIconContainer: 'hc--loading-icon',
    
    path: 'http://localhost/harpia/public/assets/img/loading.gif',
    text: null,
    
    textColor: colors.dark,
    color: colors.light,

    timeoutToRemove: 560,
  },
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

$dialog = function(custom_options = {}) {

  // Setting the options
  const options = {
    ...components.dialog,
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

  if (content.footer !== '') content.footer = `<div style="border-top: 1px solid #e0e0e0; padding-top: 1rem; text-align: right">${content.footer}</div>`

  component.innerHTML = `
    <div class="${options.classIconContainer}"><span class="mdi mdi-${content.icon}" style="font-size: 1.45rem" onclick="$dialogClose()"></span></div>
    <div style="text-align: center; font-size: 1.5rem; border-bottom: 1px solid #e0e0e0; padding-bottom: 1rem">${content.title}</div>
    <div style="padding-top: 1rem 0;">${content.description}</div>
    ${content.footer}
  `;

  // Colors
  if (options.backgroundColor) {
    component.style.backgroundColor = options.backgroundColor
  } else {
    component.style.backgroundColor = colors.color_light
  }

  if (options.textColor) {
    component.style.color = options.textColor
  } else {
    component.style.color = colors.color_dark
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
  $swiftBackground({ onclick: $dialogClose });
  
  return component;
}

$dialogClose = function() {

  let component = hget_component(components.dialog);

  // Classes
  component.classList.contains(components.dialog.classAnimateIn)
      component.classList.remove(components.dialog.classAnimateIn);
  component.classList.contains(components.dialog.classAnimateOut)
      component.classList.remove(components.dialog.classAnimateOut);

  component.classList.add(components.dialog.classAnimateOut);

  setTimeout(() => {
    component.style.display = 'none';
    $closeSwiftBackground()
  }, components.dialog.timeoutToRemove);

  return component;
}

$window = function(custom_options = {}) {

  // Setting the options
  const options = {
    ...components.window,
    ...custom_options,
  };

  component = hget_component(options, true);

  // Setting content
  content = {
    content: options.content
  }

  if (options.centerContent) {
    component.classList.add('hc--window-center');
  }

  component.innerHTML = `
    <div class="hc--window-close-icon"><span class="mdi mdi-close" style="font-size: 1.45rem; cursor: pointer" onclick="$windowClose()"></span></div>
    ${content.content}
  `;

  // Colors
  if (options.backgroundColor) {
    component.style.backgroundColor = options.backgroundColor
  } else {
    component.style.backgroundColor = colors.color_light
  }

  if (options.textColor) {
    component.style.color = options.textColor
  } else {
    component.style.color = colors.color_dark
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
  $swiftBackground({ onclick: $windowClose });
  
  return component;
}

$windowClose = function() {

  let component = hget_component(components.window);

  // Classes
  component.classList.contains(components.window.classAnimateIn)
      component.classList.remove(components.window.classAnimateIn);
  component.classList.contains(components.window.classAnimateOut)
      component.classList.remove(components.window.classAnimateOut);

  component.classList.add(components.window.classAnimateOut);

  setTimeout(() => {
    component.style.display = 'none';
    $closeSwiftBackground()
  }, components.window.timeoutToRemove);

  return component;
}

$loading = function(custom_options = {}) {

  // Setting the options
  const options = {
    ...components.loading,
    ...custom_options,
  };

  component = hget_component(options, true);

  // Setting content
  content = {
    path: options.path,
    text: options.text,
  }

  component.innerHTML = `
  <img src="${content.path}">
  `;
  if (content.text) component.innerHTML += `<div>${content.text}</div>`;

  // Colors
  if (options.backgroundColor) {
    component.style.backgroundColor = options.backgroundColor
  } else {
    component.style.backgroundColor = colors.color_light
  }

  if (options.textColor) {
    component.style.color = options.textColor
  } else {
    component.style.color = colors.color_dark
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
  
  return component;
}

$loadingClose = function() {

  let component = hget_component(components.loading);

  // Classes
  component.classList.contains(components.loading.classAnimateIn)
      component.classList.remove(components.loading.classAnimateIn);
  component.classList.contains(components.loading.classAnimateOut)
      component.classList.remove(components.loading.classAnimateOut);

  component.classList.add(components.loading.classAnimateOut);

  setTimeout(() => {
    component.style.display = 'none';
  }, components.loading.timeoutToRemove);

  return component;
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[img-view]').forEach(img => {
    img.style.cursor = 'pointer';
    img.addEventListener('click', function() {
      $window({ content: `<img src="${img.src}">`, centerContent: true })
    });
  });
});