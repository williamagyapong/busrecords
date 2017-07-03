 //make form input accept only number values
 jQuery('.numberonly').keyup(function () { 
    if(this.value != this.value.replace(/[^0-9\.]/g,'')) {
      this.value = this.value.replace(/[^0-9\.]/g,'')
    }
    //this.value = this.value.replace(/[^0-9\.]/g,'');
});
 function isNumber(name) {
 	var fieldName = name;
 	var data = document.myForm.fieldName.value;
 	     alert(data);
         if(!isNaN(data)) {
            return true;
         } else{
            alert('Invalid entry');
            document.myForm.fieldName.focus();
            return false;
         }
       }
     
  function deleteAlert()
  {
  	 response = confirm("The selected record will be deleted !");
  	 if(response) {
  	 	return true;
  	 } else {
  	 	return false;
  	 }
  }

