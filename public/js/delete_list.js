$('.fa-trash-o').click(function () {
	 $id = $(this).attr('id');
	 $('.ok').attr('data-id', $id.slice(7));
});
//Add event for button OK in modal
$('.ok').click(function () {
	$id = $(this).attr('data-id');
	$.ajax({
		type: 'POST',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url: $baseURL + '/admin/books/' + $id,
		data:{
			_method: 'delete',
		},
		success: function ($data) {
			if ($id == $data.book.id) {
				$tr = $('#delete-' + $id).parent().parent();
				$tr.attr('style', 'background-color: #aaa');
				setTimeout(function(){
					$tr.remove();
				}, 1000);
			}
			
		}
	});
});
