/**
 * @author Frederic.Vandenameele
 */


$(function() {
	//alert('ok');
	$( "#tabs" ).tabs();
	getAllData();
	
	//event listener Search by Copy Number
	$("form#searchbycopynumber").submit(function(event){
		event.preventDefault();
		copyid = $("form#searchbycopynumber input#copynumber").val();
		//alert(copyid);
		if (copyid == "") {
			alert("Copy Number can not be empty");
		} else if (isNaN(copyid)) {
			alert("Copy Number needs to be a numeric value.");
			
		} else {
			getByCopyNumber(copyid);
		}
	});
	
	//event listener Create New Movie
	$("form#createnewmovie").submit(function(event){
		event.preventDefault();
		moviename = $("form#createnewmovie input#moviename").val();
		if (moviename == "") {
			alert("Moviename can not be empty");
		} else {
			createNewMovie(moviename);
		}
	});
	
	//event listener Create New Copy
	$("form#createnewcopy").submit(function(event){
		event.preventDefault();
		copynumber = $("form#createnewcopy input#copynumber").val();
		movieid = $("form#createnewcopy select#movieid").val();
		if (copynumber == "") {
			alert("Copynumber can not be empty");
		} else if (movieid == "") {
			alert("Please select a movie");
		} else if (isNaN(movieid)) {
			alert("Movieid needs to be numeric");
		} else if (isNaN(copynumber)) {
			alert("Copynumber needs to be numeric");
		} else {
			createNewCopy(copynumber, movieid);
		}
	});
	
	//event listener Remove movie
	$("form#removemovie").submit(function(event){
		event.preventDefault();
		movieid = $("form#removemovie select#movieid").val();
		if (movieid == "") {
			alert("Please select a movie");
		} else if (isNaN(movieid)) {
			alert("Movieid needs to be numeric");
		} else {
			removeMovie(movieid);
		}
	});
	
	//event listener Remove copy
	$("form#removecopy").submit(function(event){
		event.preventDefault();
		copyid = $("form#removecopy select#copyid").val();
		if (copyid == "") {
			alert("Please select a copy");
		} else if (isNaN(copyid)) {
			alert("Copyid needs to be numeric");
		} else {
			removeCopy(copyid);
		}
	});
	
	//event listener Rent copy
	$("form#rentcopy").submit(function(event){
		event.preventDefault();
		copyid = $("form#rentcopy select#copyid").val();
		clientid = $("form#rentcopy select#clientid").val();
		if (copyid == "") {
			alert("Please select a copy");
		} else if (isNaN(copyid)) {
			alert("Copyid needs to be numeric");
		
		} else if (clientid == "") {
			alert("Please select a client");
		} else if (isNaN(clientid)) {
			alert("ClientId needs to be numeric");
		} else {
			rentCopy(copyid,clientid);
		}
	});
	
	//event listener Return copy
	$("form#returncopy").submit(function(event){
		event.preventDefault();
		copyid = $("form#returncopy select#copyid").val();
		
		if (copyid == "") {
			alert("Please select a copy");
		} else if (isNaN(copyid)) {
			alert("Copyid needs to be numeric");
		} else {
			returnCopy(copyid);
		}
	});
	
	
	
	
	
	
	
	
});

function getAllData(){
	$.ajax({
      url: 'loadall.php',
      dataType: 'json',
      async: false,
      data: 'action=all',
      success: function (data) {
      		$('.userlogin').empty();
      		$('table#movieoverview').remove();
      		$('select#movieid').empty();
      		$('select#clientid').empty();
      		$('select#copyid').empty();
    	  
	        var userlogin = "Welkom " + data.user.firstname + " " + data.user.lastname;
	        userlogin += " <a id='logout' href='logout.php'>Uitloggen</a>";
	        $('.userlogin').append(userlogin);
	        
	        var moviesoverview = "<table id='movieoverview'><tr><td id='title'><strong>Titel</strong></td><td id='number'><strong>Nummer(s)</strong></td><td id='copiesavailable'><strong>Exemplaren aanwezig</strong></td></tr>";
	        $.each(data.movies, function(){
	        	moviesoverview += "<tr><td>" + this.name + "</td>";
	        	moviesoverview += "<td>";
	        	$.each(this.copies, function(v) {
	        		if (this.clientid == null) {
	        			moviesoverview += "<strong>" + this.id + "</strong> ";
	        		} else {
	        			moviesoverview += "<span style='color:#ff0000'>" + this.id + "</span> ";
	        		}
	        	});
	        	moviesoverview += "</td>";
	        	moviesoverview += "<td>" + this.copiesavailable + "</td>";
	        });
	        $('#tabs-1').append(moviesoverview);
	        
	        //fill all select option elements for movies
	        var movieselectoptions = "<option value=''>-- Please select a movie --</option>";
	        $.each(data.movies, function(){
	        	movieselectoptions += "<option value='" + this.id + "'>" + this.name + "</option>"; 
	        });
	        $('select#movieid').append(movieselectoptions);
	        
	        //fill all select option elements for clients
	        var clientselectoptions = "<option value=''>-- Please select a client --</option>";
	        $.each(data.clients, function(){
	        	clientselectoptions += "<option value='" + this.id + "'>" + this.firstname + " " + this.lastname + "</option>"; 
	        });
	        $('select#clientid').append(clientselectoptions);
	        
	        //fill all select option elements for copies
	        var copiesselectoptions = "<option value=''>-- Please select a copy --</option>";
	        $.each(data.movies, function(){
	        	$.each(this.copies, function(){
	        		copiesselectoptions += "<option value='" + this.id + "'>" + this.id + "</option>"; 
	        	});	
	        });
	        $('select#copyid').append(copiesselectoptions);
        
      }
    });
}

function getByCopyNumber(copyid) {
	$.ajax({
	      url: 'getbycopynumber.php',
	      dataType: 'json',
	      data: {action:'searchbycopynumber', copyid: copyid},
	      success: function (data) {
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be a numeric value.';
	      				break;
	  				case 'NOT_EXIST_COPYID':
	      				message = 'The Copy Number you entered does not exist.';
	      				break;     
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
	    		  var movieoverview = "<table id='movieoverview'><tr><td id='title'><strong>Titel</strong></td><td id='number'><strong>Nummer(s)</strong></td><td id='copiesavailable'><strong>Exemplaren aanwezig</strong></td></tr>";
	    	        
	    	        	movieoverview += "<tr><td>" + data.movie.name + "</td>";
	    	        	movieoverview += "<td>";
	    	        	$.each(data.movie.copies, function(v) {
	    	        		if (this.clientid == null) {
	    	        			movieoverview += "<strong>" + this.id + "</strong> ";
	    	        		} else {
	    	        			movieoverview += "<span style='color:#ff0000'>" + this.id + "</span> ";
	    	        		}
	    	        	});
	    	        	movieoverview += "</td>";
	    	        	movieoverview += "<td>" + data.movie.copiesavailable + "</td>";
	    	        
	    	        $('#tabs-2').append(movieoverview);
	    	  }
	      }  
    });
}

function createNewMovie(name) {
	$.ajax({
	      url: 'createnewmovie.php',
	      dataType: 'json',
	      data: {action:'createnewmovie', moviename: name},
	      success: function (data) {
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
	    		  var movieoverview = "<table><tr><td id='title'><strong>Titel</strong></td><td id='number'><strong>Nummer(s)</strong></td></tr>";
	    	        
  	        	movieoverview += "<tr><td>" + data.movie.name + "</td>";
  	        	movieoverview += "<td>";
  	        	$.each(data.movie.copies, function(v) {
  	        		if (this.clientid == null) {
  	        			movieoverview += "<strong>" + this.id + "</strong> ";
  	        		} else {
  	        			movieoverview += "<span style='color:#ff0000'>" + this.id + "</span> ";
  	        		}
  	        	});
  	        	movieoverview += "</td>";
  	        	  	        	
  	        	getAllData();
  	        	$('#tabs-3').append(movieoverview);
	    		alert('New Movie created.');
	    	  }
	      }  
  });
}

function createNewCopy(copynumber, movieid) {
	$.ajax({
	      url: 'createnewcopy.php',
	      dataType: 'json',
	      data: {action:'createnewcopy', copynumber: copynumber, movieid: movieid},
	      success: function (data) {
	    	  
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be numeric.';
	      				break;
	  				case 'IS_EMPTY_MOVIEID':
	      				message = 'Please select a movie.';
	      				break;
	  				case 'IS_NOT_NUMERIC_MOVIEID':
	      				message = 'Movie id needs to be numberic.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
	    		  	var movieoverview = "<table id='movieoverview'><tr><td id='title'><strong>Titel</strong></td><td id='number'><strong>Nummer(s)</strong></td></tr>";
	    	        
		        	movieoverview += "<tr><td>" + data.movie.name + "</td>";
		        	movieoverview += "<td>";
		        	$.each(data.movie.copies, function(v) {
		        		if (this.clientid == null) {
		        			movieoverview += "<strong>" + this.id + "</strong> ";
		        		} else {
		        			movieoverview += "<span style='color:#ff0000'>" + this.id + "</span> ";
		        		}
		        	});
		        	movieoverview += "</td>";
		        	
		        	
		        	getAllData();
		        	$('#tabs-4').append(movieoverview);
		    		alert('New Copy created.');
	    	  }
	      }  
	});
}

function removeMovie(movieid) {
	$.ajax({
	      url: 'removemovie.php',
	      dataType: 'json',
	      data: {action:'removemovie', movieid: movieid},
	      success: function (data) {
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be numeric.';
	      				break;
	  				case 'IS_EMPTY_MOVIEID':
	      				message = 'Please select a movie.';
	      				break;
	  				case 'IS_NOT_NUMERIC_MOVIEID':
	      				message = 'Movie id needs to be numberic.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
	    		  getAllData();
	    		  $( "#tabs" ).tabs( "option", "active", 0 );
	    		  alert('Movie deleted.');
	    	  }
	      }  
	});
}

function removeCopy(copynumber) {
	$.ajax({
	      url: 'removecopy.php',
	      dataType: 'json',
	      data: {action:'removecopy', copynumber: copynumber},
	      success: function (data) {
	    	  
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be numeric.';
	      				break;
	  				case 'IS_EMPTY_MOVIEID':
	      				message = 'Please select a movie.';
	      				break;
	  				case 'IS_NOT_NUMERIC_MOVIEID':
	      				message = 'Movie id needs to be numberic.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
	    		  	
		        	
		        	getAllData();
		        	$( "#tabs" ).tabs( "option", "active", 0 );
		    		alert('Copy Deleted.');
	    	  }
	      }
	});
}

function rentCopy(copyid,clientid) {
	$.ajax({
	      url: 'rentcopy.php',
	      dataType: 'json',
	      data: {action:'rentcopy', copyid: copyid, clientid: clientid},
	      success: function (data) {
	    	  
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be numeric.';
	      				break;
	  				case 'IS_EMPTY_MOVIEID':
	      				message = 'Please select a movie.';
	      				break;
	  				case 'IS_NOT_NUMERIC_MOVIEID':
	      				message = 'Movie id needs to be numeric.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
		        	getAllData();
		        	$( "#tabs" ).tabs( "option", "active", 0 );
		    		alert('Copy Rented.');
		    		
		    		
	    	  }
	      }
	});
}

function returnCopy(copyid) {
	$.ajax({
	      url: 'returncopy.php',
	      dataType: 'json',
	      data: {action:'returncopy', copyid: copyid},
	      success: function (data) {
	    	  
	    	  if (data.exceptions) {
	    		  switch (data.exceptions[0]) {
	  				case 'IS_EMPTY_COPYID':
	      				message = 'Copy Number can not be empty.';
	      				break;
	  				case 'IS_NOT_NUMERIC_COPYID':
	      				message = 'Copy Number needs to be numeric.';
	      				break;
	  				case 'IS_EMPTY_MOVIEID':
	      				message = 'Please select a movie.';
	      				break;
	  				case 'IS_NOT_NUMERIC_MOVIEID':
	      				message = 'Movie id needs to be numberic.';
	      				break;
	  				default:
	      				message = 'Error!';
					}
					alert(message);
	    	  } else {
		        	getAllData();
		        	$( "#tabs" ).tabs( "option", "active", 0 );
		    		alert('Copy Returned.');
	    	  }
	      }
	});
}

