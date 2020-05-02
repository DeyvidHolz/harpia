class DOM {

  static toValueOr(selector, alternativeValue = '') {
    const element  = document.querySelector(selector);

    if (element != null && element !== undefined) {
      return element.value != null && element.value != undefined ? element.value : element.innerHTML;
    }

    return '';

  }

  static resetAllInputs() {
    document.querySelectorAll('input').forEach(input => {
      input.value = '';
    });
  }

}