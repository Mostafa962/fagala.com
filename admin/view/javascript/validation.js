/*  form validation*/
$( "#form-cost" ).validate({
  rules: {
    cost_description: {
      required: true,
      
    },
    cost_value: {
      required: true,
      minlength : 6,
      maxlength: 500
    }

  }
});