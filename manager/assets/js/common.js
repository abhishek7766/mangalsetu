/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteMember", function(){
		var memberId = $(this).data("memberid"),
			hitURL = baseURL + "deleteMember",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Member ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { memberId : memberId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Member successfully deleted"); }
				else if(data.status = false) { alert("Member deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".activeAnnouncement", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "activeAnnouncement",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to Acivate this Announcement ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				if(data.status = true) { alert("Announcement successfully Activated");location.reload(); }
				else if(data.status = false) { alert("Announcement deletion Deactivate");location.reload(); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deactiveAll", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deactiveAll",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to Deactivate All Announcements ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				if(data.status = true) { alert("All Announcement successfully Dectivated");location.reload(); }
				else if(data.status = false) { alert("Announcement deletion Deactivate");location.reload(); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".deleteAnnouncement", function(){
		var id = $(this).data("id"),
			hitURL = baseURL + "deleteAnnouncement",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Announcement ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Announcement successfully deleted"); }
				else if(data.status = false) { alert("Announcement deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
