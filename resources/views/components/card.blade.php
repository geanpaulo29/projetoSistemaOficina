@props(['title' => null, 'headerClass' => 'bg-primary text-white', 'footer' => null])

<div {{ $attributes->merge(['class' => 'card card-custom mb-4']) }}>
    @if($title)
        <div class="card-header card-header-custom {{ $headerClass }}">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer bg-light">
            {{ $footer }}
        </div>
    @endif
</div>