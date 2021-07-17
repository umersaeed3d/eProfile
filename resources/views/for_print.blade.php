<!DOCTYPE html>
<html>
<head>
	<title>Technical Bid</title>
</head>
<body>
	@if(!isset ($filename_with))
	
	<iframe src="{{asset("uploads/files/merged/".$filename.".pdf")}}" style="width:1300px; height:1100px;" frameborder="0"></iframe>
	{{-- <embed src="{{ asset('uploads/files/01.pdf')}}" width="545px" height="842px" /> --}}
	{{-- <embed src="{{ asset('uploads/files/01.pdf') }}" width="100%" height="2100px" /> --}}
	
	@else
			@foreach ($filename_with as $element)
				<iframe src="{{asset("uploads/files/merged/".$element)}}" style="width:1300px; height:1100px;" frameborder="0"></iframe>
			@endforeach
			
		
	
	@endif
</body>
</html>