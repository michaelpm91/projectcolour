
$( document ).ready(function() {

var selectedChar=-1;
var weezer=-1;
var colourIndex=["#CC0000","#FF7900","#689C00","#80004D"];
var colourInt = setInterval(function(){changeColour()},3000);

 
 $("#genre-select").on('change', function(e) {
     if ($("#genre-select").val()) {
         
         $.ajax({
             type: "GET",
             url: "colors_by_genre.php",
             data: { "genre": $("#genre-select").val()},
             success: function(data) {
                 redrawStripe(data);
             }
         });
     }
 });

 function redrawStripe(colorsObject) {
     var colors = colorsObject.colors;
     var width = 830 / colors.length;
     $("#data").fadeOut(400, function(){
         $("#data").empty();
         $.each(colors, function(i, color) {
             $('<div style="display: inline-block; width: '+parseInt(width)+'px; height: 200px; background: '+color+'"></div>').appendTo($("#data"));
             $("#data").fadeIn(400);
         });
     });
     
 }
 
 function changeColour(){
 

 	weezer++;
 	
 	$(".weezer span").css("display","block");
 	
 	if(weezer==0){
 		
 		$("#blue").fadeTo(1000,0);
 		$("#green").fadeTo(1000,1);
 		
 	}
 	
  	
 	if(weezer==1){
 		
 		$("#green").fadeTo(1000,0);
 		$("#red").fadeTo(1000,1);
 		
 	}
 
  	if(weezer==2){
 		
 		$("#red").fadeTo(1000,0);
 		$("#blue").fadeTo(1000,1);
		weezer=-1;

 	}
 
 
 
	/*
	selectedChar++;


	$("#fill").fadeTo(1000,0,function(){
		$("#fill").css( "background", ""+colourIndex[selectedChar]+"" );

		$("#fill").fadeTo(1000,1);

	});	
 
 
	 if(selectedChar >= colourIndex.length){
		selectedChar=0;
	}
	*/
	
	/*
 
	var randomColour=Math.floor((Math.random() * colourIndex.length));
	
	selectedChar++;
	
	if(selectedChar >= $("h1 span").length){
		selectedChar=0;
	}
	
	$("h1 span").css("color","#999");
	
	$("h1 span:eq("+selectedChar+")").fadeTo(100,0.1,function(){
		$("h1 span:eq("+selectedChar+")").fadeTo(800,1);
		$("h1 span:eq("+selectedChar+")").css( "color", ""+colourIndex[randomColour]+"" );

	});

	*/
	

 
 }







});