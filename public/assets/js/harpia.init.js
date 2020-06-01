function _loaded (exec) {
  document.addEventListener('DOMContentLoaded', exec);
}

function autofill (arr) {
  /*
   * Description: autofill inputs
   *
   * How to use:
   *
   * @param: Array of objects
   * -> Example: [ { selector: '#username', value: 'username1' } ]
   */

  arr.forEach(data => {
    let field = document.querySelector(data.selector);

    if (field instanceof HTMLTextAreaElement) {
      field.innerHTML += data.value;
    } else if (field instanceof HTMLInputElement) {
      field.value += data.value
    }
  });
}

function resetInputs (selectors) {

  /*
   * Description: reset value of inputs.
   * Obs.: compatible with autofill @param.
   *
   * How to use:
   *
   * @param: Array of strings (HTML Selectors)
   * -> Example: [ '#name', '#age', '#email' ]
   */

  let tempArray = [];
  if (typeof selectors[0] === "object") {
    selectors.forEach(selector => {
      tempArray.push(selector.selector);
    });
  }

  selectors = tempArray;

  selectors.forEach(selector => {
    const field = document.querySelector(selector);

    if (field) {
      if (field instanceof HTMLTextAreaElement) {
        field.innerHTML = ''
      } else if (field instanceof HTMLInputElement) {
        field.value = ''
      }
    }
  })
}