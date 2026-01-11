<div id="banner-carousel" class="relative w-full" data-carousel="slide">
<div class="relative h-56 md:h-96 overflow-hidden rounded-lg">

@foreach($banners as $i=>$b)
<div class="@if($i!=0) hidden @endif" data-carousel-item>
<img src="{{ asset('storage/'.$b->image) }}"
     class="w-full h-full object-cover">
</div>
@endforeach

</div>
</div>
