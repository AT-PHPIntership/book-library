// Object
var user = (function(){
  
  // Constructor
  var user = function(){
  }

  // Methods
  var updateRole = function() {
    classBtnChangeRoles = document.getElementsByClassName('btn-change-role');
    for (let classBtnChangeRole of classBtnChangeRoles) {
      if (classBtnChangeRole.getAttribute('disabled') !== '') {
        classBtnChangeRole.addEventListener('click', function () {
          let id = classBtnChangeRole.getAttribute('id').slice(5);
          token = $('meta[name="csrf_token"]').attr('content');
          $.ajax({
            type:'PUT',
            headers: { 'X-CSRF-TOKEN': token },
            url: '/admin/users/' + id + '/roles',
            data:{
            },
            success: function (data) {
              btnChangeRole = document.getElementById('role-' + id);
              if (data === 0) {
                btnChangeRole.innerHTML = nameRole.user;
                btnChangeRole.setAttribute('class', 'btn-change-role width-70 btn btn-danger');
              } else {
                if (data === 1) {
                  btnChangeRole.innerHTML = nameRole.admin;
                  btnChangeRole.setAttribute('class', 'btn-change-role width-70 btn btn-success');
                }
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
    updateRole: updateRole
  }

  // Return user;
  return user;
})();

var newUser = new user();
