$(document).ready(
    function(){

      $("#page1").hide();
      $("#form1").hide();
      $("#nextPage").click(nextpage);
      $("#nextPage2").click(nextpage2);

 });

function nextpage() {
	$("#intro").hide();
	$("#page1").show("slow");
}
function nextpage2() {
	$("#page1").hide();
	$("#form1").show("slow");
}