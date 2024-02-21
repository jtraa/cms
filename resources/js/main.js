// INITIALIZE AOS
window.AOS = require('AOS');

$( document ).ready(function() {

	// AOS INIT
  	AOS.init();

  	$('.arrow').click(function(){
	  	$(this).children().children().siblings('i').toggleClass('fa-chevron-down');
	  	$(this).children().children().siblings('i').toggleClass('fa-chevron-up');
	  	$(this).siblings().slideToggle('hidden');
  	});

	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function () {
	  'use strict'

	  // Fetch all the forms we want to apply custom Bootstrap validation styles to
	  var forms = document.querySelectorAll('.needs-validation')

	  // Loop over them and prevent submission
	  Array.prototype.slice.call(forms)
	    .forEach(function (form) {
	      form.addEventListener('submit', function (event) {
	        if (!form.checkValidity()) {
	          event.preventDefault()
	          event.stopPropagation()
	        }
	        if($("#checkbox-form").prop('checked') == false){
		        event.preventDefault()
		        event.stopPropagation()
		        $('#alert').modal('show');
			}
			if (!form.checkValidity()) {

	        }
	        form.classList.add('was-validated')
	      }, false)
	    })
	})()


	// HAMBURGER
	$('#nav-icon4').on('click', function(){
		$(this).toggleClass('open');
		$('.navigation ul').slideToggle('hidden');
	});

});
