@props(['color' => 'green', 'size' => 'small'])

<div class="preloader-wrapper {{ $size }} active">
    <div class="spinner-layer spinner-{{ $color }}-only">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
</div>
