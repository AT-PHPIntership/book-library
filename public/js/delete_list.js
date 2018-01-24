$('.fa-trash-o').click(function () {
	 $id = $(this).attr('id');
	 $('.ok').attr('data-id', $id);
	 $content = $(this).attr('data-name');
	 $('.text-center strong').html($content + " book");
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
			if ($data.book.id == undefined){
				$tr = $('#' + $id).parent().parent();
				$tr.attr('style', 'background-color: #aaa');
				setTimeout(function(){
					$tr.remove();
				}, 1000);
			}
		}
	});
});
