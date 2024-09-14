<div class="card">
    <div class="shadow-lg card-body {{ $color }}">
        <p class="fs-5">
            <span class="{{ $icons ?? 'lni lni-question-circle' }}"></span>
            {{ $title ?? '' }}
        </p>
        <p class="fw-bold fs-2">{{ $data ?? 0 }}</p>
    </div>
</div>
