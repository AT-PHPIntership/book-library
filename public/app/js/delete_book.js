var $btnOK = document.getElementById('ok');

//Add event for each button delete
var $btnDelete = document.getElementsByClassName('fa-trash-o');
for (let $eachBtn of $btnDelete) {
	$eachBtn.addEventListener('click', function () {
		$id = $eachBtn.getAttribute('id');
		$btnOK.setAttribute('data-id', $id.slice(7));
	});
}
// var $url = "{{ url('') }}";
//Add event for button OK in modal
$btnOK.addEventListener('click', function () {
	$id = $btnOK.getAttribute('data-id');
	// $token = $('meta[name="csrf_token"]').attr('content');
	$.ajax({
		type: 'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: $baseURL + '/admin/books/' + $id,
		data:{
			_method: 'delete',
		},
		dataType: 'JSON',
		success: function ($data) {
			console.log($data);
			$btnDelete = document.getElementById('delete-'+$id);
			$tr = $btnDelete.parentElement.parentElement;
			$tr.setAttribute('style', 'background-color: #aaa');
			$tbody = $tr.parentElement;
			setTimeout(function(){
				$tbody.removeChild($tr);
			}, 1000);
		}
	});
});
