jQuery( document ).ready(function() {

	  // Handler for .ready() called.

	  jQuery(".checkAll").click(function () {

     		jQuery('input:checkbox').not(this).prop('checked', this.checked);

 	  });

	});



	function delete_item(){
		var cvid = []; 
		var cvid = jQuery('input[class="item"]:checked').map(function() {
			return this.value;
		}).get();
		var jobid = cvid.toString();

		if(jobid == ''){

		   alert('Select any one record.');

		   return false;

		}else{

			jQuery("#delete").val(cvid);

			jQuery("#form3").submit();

		}

	}

	function edit_item(){

		var cvid = []; 

		jQuery(".item").each(function(){

			if(jQuery(this).attr("checked")){

				 cvid.push($(this).val());   

			}

		});

		var jobid = cvid.toString();

		if(cvid.length > 1 || jobid == ''){

		   alert('Select only one job');

		   return false;

		}else{

			//window.location.href = "options-general.php?page=Item_gallery&edit="+cvid;

		}

	}
