function view_array(string){
var view_array = document.getElementById('view_array');
view_array.innerHTML = "<hr><hr><pre><code>"+ JSON.stringify(string,undefined,2) +"</code></pre>";
}
document.write("<div id=view_array></div>");


function setCookie(cookie_name,cookie_value){
  var now = new Date();
  now.setTime(now.getTime() + 1000 * 36000 * 10000);
  document.cookie = cookie_name+"="+cookie_value+"; expires=" + now.toUTCString() + "; path=/";
}

function deleteCookie(cookie_name){
  document.cookie = cookie_name+"=value; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function getCookie(cookie_name) {
    function escape(s) { return s.replace(/([.*+?\^${}()|\[\]\/\\])/g, '\\$1'); };
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(cookie_name) + '=([^;]*)'));
    return match ? match[1] : null;
}

function auto_check_with(input_name,target_value){
  $("input[name='" + input_name + "'][value='" + target_value + "']").attr('checked', true);
}
function auto_select_with(input_name,target_value){
  $("select[name='" + input_name + "'] option[value='" + target_value + "']").attr('selected', true);
}
