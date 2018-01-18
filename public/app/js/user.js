// Object
var user = (function(){
  
  // Constructor
  var user = function(){
  }

  // Methods
  var update_role = function() {
    $classbtn = document.getElementsByClassName('update');
    for (let $eachbtn of $classbtn) {
      if($eachbtn.getAttribute('disabled') !== '') {
        $eachbtn.addEventListener('click', function () {
          let $id = $eachbtn.getAttribute('id').slice(5);
          token = $('meta[name="csrf_token"]').attr('content');
          $.ajax({
            type:'PUT',
            headers: { 'X-CSRF-TOKEN': token },
            url: '/admin/users/' + $id + '/roles',
            data:{
            },
            success: function (data) {
              $btnRole = document.getElementById('role-' + $id);
              if (data.user.role === 0) {
                $btnRole.innerHTML = $name_role.user;
                $btnRole.setAttribute('class', 'update width-70 btn btn-danger');
              } else {
                $btnRole.innerHTML = $name_role.admin;
                $btnRole.setAttribute('class', 'update width-70 btn btn-success');
              }
            }
          });
        });
      };
    }
  }

  // Prototype
  user.prototype = {
    constructor: user,
    update_role :update_role
  }

  // Return user;
  return user;
})();

var $new_user = new user();
