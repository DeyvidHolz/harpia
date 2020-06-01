/*
 * Autor: Deyvid
 * Versão: 1.0
 * Descrição: Automação de formulários com jQuery (ajax)
 * 
 * Função: criado para agilizar o processo de criação de formulários que fazem requisições com jQuery.
 *
 * Como usar:
 * 1. Insira um container na sua página (seja um form, div, etc).
 * 2. Coloque o atributo formize="url_de_requisicao"
 * 3. Coloque os inputs dentro desse container
 * 4. Coloque um button, a, ou outro elemento com o atributo "formize-submit".
 * 5. Pronto!
 * 
 * OBS: para ver a resposta da API você pode criar uma função e passar como atributo para o container.
 * Ex: <form formize="requisicao.php" form-method="post" form-complete="minhaFuncao(resposta)"
 * -- function minhaFuncao(resposta) { console.log('Reposta:', resposta); }
 * 
 * OBS: valor padrão de "form-method" é POST.
*/

function formizeRequest(request) {

  $.ajax({
    url: request.url,
    method: request.method,
    data: request.data ? request.data : null,
    success: function(res) { eval(request.success) },
    error: function(err) { eval(request.error) },
    complete: function(res) { eval(request.complete) }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[formize]').forEach(el => {

    // Setar tudo aqui caso for null
    if (!el.getAttribute('formize')) el.setAttribute('formize', '');
    if (!el.getAttribute('form-method')) el.setAttribute('form-method', 'POST');
    if (!el.getAttribute('form-success')) el.setAttribute('form-success', '');
    if (!el.getAttribute('form-error')) el.setAttribute('form-error', '');
    if (!el.getAttribute('form-complete')) el.setAttribute('form-complete', '');

    // Montando objeto
    const request = {};
    const url = el.getAttribute('formize');
    const method = el.getAttribute('form-method');
    
    let success = el.getAttribute('form-success');
    let error = el.getAttribute('form-error');
    let complete = el.getAttribute('form-complete');
    
    if (success.length > 0 && !success.match(/\((.*?)\)/gi)) success += '()';
    if (error.length > 0 && !error.match(/\((.*?)\)/gi)) error += '()';
    if (complete.length > 0 && !complete.match(/\((.*?)\)/gi)) complete += '()';
    
    request.url = url;
    request.method = method;
    request.success = success;
    request.error = error;
    request.complete = complete;

    // Submit action
    let data = {};
    let arrData = [];

    if (el.querySelector('[formize-submit]')) {
      el.querySelector('[formize-submit]').addEventListener('click', function(e) {

        e.preventDefault();
  
        // Some elements don't have a "value" property, here you can change the property who saves the element's value.
        // Ex: checkbox = .checked
        let customTypes = {
          'checkbox': 'checked',
        };
  
        el.querySelectorAll('input').forEach(field => {
          if (!field.hasAttribute('disabled') && !field.getAttribute('type').match(/radio/i)) {
            let id, value = null;
  
            // ID can be the element's ID or the element's "name" attribute.
            if (field.hasAttribute('id')) {
              id = field.getAttribute('id');
            } else if (field.hasAttribute('name')) id = field.getAttribute('name');
  
            // Value can be the element's value or the element's custom value (reference array: customTypes)
            if (field.hasAttribute('type')) {
              if (customTypes[field.getAttribute('type')] !== undefined) {
                value = eval(`field.${customTypes[field.getAttribute('type')]}`);
              } else {
                value = field.value
              }
            }
  
            if (id != null) {
              arrData.push({ id, value });
            }
          }
        });
  
        el.querySelectorAll('input[type="radio"]').forEach(field => {
          if (!field.hasAttribute('disabled') && field.hasAttribute('name')) {
            let id, value = null;
            id = field.getAttribute('name');
  
            if (field.checked) {
              value = field.value;
              arrData.push({ id, value });
              return arrData;
            }
          }
        });

        el.querySelectorAll('textarea').forEach(field => {
          if (!field.hasAttribute('disabled') && (field.hasAttribute('id') || field.hasAttribute('name'))) {
            let id, value = null;
            id = field.getAttribute('id') ? field.getAttribute('id') : field.getAttribute('name');
            value = field.value
  
            arrData.push({ id, value });
          }
        });
  
        arrData.forEach(d => {
          data[d.id] = d.value;
        });
  
        request.data = data;
  
        data = {};
        arrData = [];
  
        formizeRequest(request);
      });
    } else {
      console.error('Form found, but "formize-submit" element not.\nPlease, create a element with attribute "formize-submit".')
    }

  });
});