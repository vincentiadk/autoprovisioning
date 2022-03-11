@include('layouts.head')
@include('layouts.header')
<div id="myContent" :title="title">
    @include('layouts.sidebar')
    <router-view>
    </router-view>
</div>
@include('layouts.footer')