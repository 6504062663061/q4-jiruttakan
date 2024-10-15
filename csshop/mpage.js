function toggle_visibility(id) {
  var e = document.getElementById(id);
  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}
window.onresize = function(event) {
  var e = document.getElementById("menu");
  var w = window.innerWidth;
  if(w > 599)
    e.style.display = 'block';
  else
    e.style.display = 'none';
};

function confirmDelete(username){
  var ans = confirm("ต้องการลบสมาชิก " + username);
  if(ans == true)
      document.location = "./member_php/deleteMsql.php?username=" + username;
}





function update(pid) {
    var qty = document.getElementById(pid).value;
    // ส่งรหัสสินค้าและจำนวนไปปรับปรุงใน session
    document.location = "./cart/cart.php?action=update&pid=" + pid + "&qty=" + qty;
}


