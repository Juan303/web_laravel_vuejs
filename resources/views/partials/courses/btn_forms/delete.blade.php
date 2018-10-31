<form action="{{ route('courses.destroy', ['slug' => $course->slug]) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger text-white">
        <i class="fa fa-trash"></i> {{ __('Eliminar curso') }}
    </button>
</form>