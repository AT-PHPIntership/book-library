<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <p>Dear <strong>{{ $borrowing->users->name }}</strong>,</p>

  <p>It has been <b class="color-red">{{Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($borrowing->from_date))}}</b> days since you borrowed the book <strong>{{$borrowing->books->name}}</strong>,
  <br> and we hope you enjoyed it. Now it’s time to get it returned to AT Library 
  <br>and explore more other interesting books.</p>

  <div>
    <p>Sincerely,</p>
    <strong>AT Library team</strong>
  </div>

</body>
</html>
