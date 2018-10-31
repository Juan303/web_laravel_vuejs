<div class="col-12 col-md-6 mt-0 pt-0">
    <h2 class="text-muted">
        {{ __('Requisitos del curso') }}
    </h2>
    <hr />
    @forelse($requirements as $requirement)

        <div class="card bg-light p-3 mb-1">
            <p class="mb-0">
                {{ $requirement->requirement }}
            </p>
        </div>

    @empty
        <div class="alert alert-dark">
            <i class="fa fa-info-circle"></i>
            {{ __('Este curso no tiene requisitos previos') }}
        </div>
    @endforelse
</div>
