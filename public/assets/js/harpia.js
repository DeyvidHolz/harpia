function redirect(path, newTab = false) {
  return newTab ? window.open(path) : window.location.href = path;
}

function getElementsMaxHeight (selector) {
  let heightList = [];

  document.querySelectorAll(selector).forEach(el => {
    heightList.push(el.offsetHeight);
  });

  return Math.max(...heightList);
}

function setHeight (selector, height, unit_m = 'px') {
  document.querySelectorAll(selector).forEach(el => {
    el.style.height = height + String(unit_m);
  });
}

function setDefaultHeight (selector) {
  const maxHeight = getElementsMaxHeight(selector);
  setHeight(selector, maxHeight);
  return maxHeight;
}