@include('layouts.head')
@include('layouts.header')
@include('layouts.sidebar')
<div id="myContent">
@include($data['content'], $data)
</div>
@include('layouts.footer')