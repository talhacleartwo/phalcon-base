/*Modals*/
// Get the button that opens the modal
jQuery(document).ready(function(){
	var btns = jQuery("button[data-modal]");
	btns.click(function(e){
		e.preventDefault(); 
		var t = jQuery(e.currentTarget).attr('data-modal');
		jQuery('.modal#'+t).css('display','block');
		var m = jQuery('.modal#'+t);
		window.onclick = function(event) {
		  if (event.target == m[0]) {
			jQuery(m).css('display','none');
		  }
		}
		//jQuery(window).click(function(e){if(e.currentTarget == m){jQuery(m).css('display','none');}});
	});
	var closes = jQuery('.modal .close').click(function(e){var m = jQuery(e.currentTarget).closest('.modal'); jQuery(m).css('display','none');});
});
// Get the <span> element that closes the modal
/*var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}*/