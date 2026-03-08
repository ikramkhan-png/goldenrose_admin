<div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
    <h5 class="mb-2">{{ $title }}</h5>
    @if(isset($description))
        <p class="mb-0" style="opacity: 0.9;">{{ $description }}</p>
    @endif
</div>